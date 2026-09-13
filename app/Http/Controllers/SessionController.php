<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\SessionParticipant;
use App\Models\RollLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function entrarForm()
    {
        return view('session.entrar');
    }

    public function entrar(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|size:6|exists:game_sessions,session_code'
        ]);

        $session = Session::where('session_code', $request->codigo)
            ->where('status', 'active')
            ->firstOrFail();

        $exists = SessionParticipant::where('game_session_id', $session->id)
            ->where('user_id', Auth::id())
            ->exists();

        if (!$exists) {
            $session->participants()->create(['user_id' => Auth::id()]);
        }

        return redirect()->route('rolagens.index')->with('session_code', $session->session_code);
    }

    /**
     * Endpoint REST simples — usado como fallback e para o primeiro carregamento.
     */
    public function getMinhaSessao()
    {
        $user = Auth::user();
        $session = Session::where('status', 'active')
            ->whereHas('participants', fn($q) => $q->where('user_id', $user->id))
            ->first();

        if (!$session) {
            return response()->json(['in_session' => false]);
        }

        return response()->json($this->buildSessionPayload($session));
    }

    /**
     * SSE — Server-Sent Events. Mantém conexão aberta e envia atualizações
     * de dados/eventos em tempo real (verifica mudanças a cada 400ms).
     */
    public function stream()
    {
        // Prepara o PHP para streaming
        @ini_set('zlib.output_compression', '0');
        @ini_set('output_buffering', '0');
        @ini_set('implicit_flush', '1');
        @set_time_limit(0);

        // Limpa qualquer buffer ativo
        while (ob_get_level() > 0) {
            @ob_end_clean();
        }

        $user = Auth::user();

        $session = Session::where('status', 'active')
            ->whereHas('participants', fn($q) => $q->where('user_id', $user->id))
            ->first();

        $sessionId    = $session?->id;
        $sessionCode  = $session?->session_code;
        $masterUserId = $session?->master_user_id;

        // Libera o lock da sessão para não bloquear outros requests do mesmo usuário
        if (function_exists('session_write_close')) {
            session_write_close();
        }

        return response()->stream(function () use ($sessionId, $sessionCode, $masterUserId) {

            // Sem sessão ativa: informa e encerra (cliente cai para polling)
            if (!$sessionId) {
                echo "retry: 3000\n\n";
                echo "event: nosession\n";
                echo "data: {}\n\n";
                @ob_flush();
                flush();
                return;
            }

            $lastHash         = null;
            $start            = time();
            $maxDuration      = 30;   // segundos por conexão (cliente reconecta)
            $lastSessionCheck = 0;

            // Sugere ao cliente reconectar em 1s se a conexão cair
            echo "retry: 1000\n\n";
            @ob_flush();
            flush();

            while ((time() - $start) < $maxDuration) {

                if (connection_aborted()) {
                    break;
                }

                $now = time();

                // Verifica se a sessão continua ativa a cada 5s
                if (($now - $lastSessionCheck) >= 5) {
                    $lastSessionCheck = $now;
                    $alive = Session::where('id', $sessionId)
                        ->where('status', 'active')
                        ->exists();

                    if (!$alive) {
                        echo "event: ended\n";
                        echo "data: {\"reason\":\"session_closed\"}\n\n";
                        @ob_flush();
                        flush();
                        break;
                    }
                }

                // Carrega participantes + última rolagem de cada um (query única)
                $participants = SessionParticipant::where('game_session_id', $sessionId)
                    ->with(['user:id,name,crystal_id,foto'])
                    ->get();

                $userIds = $participants->pluck('user_id')->unique()->all();

                $rolls = RollLog::whereIn('user_id', $userIds)
                    ->orderBy('id', 'desc')
                    ->get()
                    ->groupBy('user_id')
                    ->map(fn($logs) => $logs->first());

                $data = [];
                foreach ($participants as $p) {
                    $u = $p->user;
                    if (!$u) continue;
                    $r = $rolls->get($u->id);

                    $data[] = [
                        'user_id'    => $u->id,
                        'name'       => $u->name,
                        'crystal_id' => $u->crystal_id,
                        'foto'       => $u->foto ? route('media.show', $u->foto) : null,
                        'is_master'  => $u->id === $masterUserId,
                        'last_dice'  => $r->dice_result  ?? null,
                        'last_event' => $r->event_result ?? null,
                        'updated_at' => $r ? ($r->updated_at?->getTimestamp() ?? 0) : 0,
                    ];
                }

                // Ordena para gerar hash estável
                usort($data, fn($a, $b) => $a['user_id'] <=> $b['user_id']);
                $hash = md5(json_encode($data));

                if ($hash !== $lastHash) {
                    $lastHash = $hash;

                    $payload = json_encode([
                        'in_session'   => true,
                        'session_code' => $sessionCode,
                        'participants' => $data,
                    ]);

                    echo "event: update\n";
                    echo "data: {$payload}\n\n";
                } else {
                    // Heartbeat (mantém proxies/firewalls satisfeitos)
                    echo ": hb {$now}\n\n";
                }

                @ob_flush();
                flush();

                usleep(400000); // 400ms entre checagens
            }
        }, 200, [
            'Content-Type'      => 'text/event-stream; charset=utf-8',
            'Cache-Control'     => 'no-cache, no-store, must-revalidate',
            'Pragma'            => 'no-cache',
            'X-Accel-Buffering' => 'no',   // nginx: desabilita buffering
            'Connection'        => 'keep-alive',
        ]);
    }

    public function sair()
    {
        $user = Auth::user();
        $participant = SessionParticipant::where('user_id', $user->id)
            ->with('session')
            ->first();

        if ($participant && $participant->session && $participant->session->status === 'active') {
            $participant->delete();
        }

        return redirect()->route('rolagens.index')->with('success', 'Você saiu da sessão.');
    }

    /**
     * Monta o payload completo da sessão (usado pelo REST e como base do SSE).
     */
    private function buildSessionPayload(Session $session): array
    {
        $participants = $session->participants()
            ->with(['user:id,name,crystal_id,foto'])
            ->get();

        $userIds = $participants->pluck('user_id')->unique();
        $lastRolls = RollLog::whereIn('user_id', $userIds)
            ->orderBy('id', 'desc')
            ->get()
            ->groupBy('user_id')
            ->map(fn($logs) => $logs->first());

        $data = $participants->map(function ($p) use ($lastRolls, $session) {
            $u = $p->user;
            $r = $lastRolls->get($u->id);

            return [
                'user_id'    => $u->id,
                'name'       => $u->name,
                'crystal_id' => $u->crystal_id,
                'foto'       => $u->foto ? route('media.show', $u->foto) : null,
                'is_master'  => $u->id === $session->master_user_id,
                'last_dice'  => $r->dice_result  ?? 'Nenhuma rolagem',
                'last_event' => $r->event_result ?? 'Nenhum evento',
            ];
        })->values()->toArray();

        return [
            'in_session'   => true,
            'session_code' => $session->session_code,
            'participants' => $data,
        ];
    }
}