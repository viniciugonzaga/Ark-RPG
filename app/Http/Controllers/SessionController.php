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

    public function stream(Request $request)
    {
        @ini_set('zlib.output_compression', '0');
        @ini_set('output_buffering', '0');
        @ini_set('implicit_flush', '1');
        @set_time_limit(0);
        @apache_setenv('no-gzip', '1');

        while (ob_get_level() > 0) { @ob_end_clean(); }

        $user = Auth::user();
        $code = $request->query('code');

        if ($code) {
            // Mestre ou participante de uma sessão específica
            $session = Session::where('session_code', $code)
                ->where('status', 'active')
                ->where(function ($q) use ($user) {
                    $q->where('master_user_id', $user->id)
                      ->orWhereHas('participants', fn($p) => $p->where('user_id', $user->id));
                })
                ->first();
        } else {
            $session = Session::where('status', 'active')
                ->whereHas('participants', fn($q) => $q->where('user_id', $user->id))
                ->first();
        }

        $sessionId    = $session?->id;
        $sessionCode  = $session?->session_code;
        $masterUserId = $session?->master_user_id;

        if (function_exists('session_write_close')) {
            session_write_close();
        }

        return response()->stream(function () use ($sessionId, $sessionCode, $masterUserId) {

            if (!$sessionId) {
                echo "retry: 2000\n\n";
                echo "event: nosession\n";
                echo "data: {}\n\n";
                @ob_flush(); flush();
                return;
            }

            $lastHash         = null;
            $start            = microtime(true);
            $maxDuration      = 5;
            $lastSessionCheck = 0;

            echo "retry: 500\n\n";
            echo ":" . str_repeat(' ', 2048) . "\n\n";
            @ob_flush(); flush();

            while ((microtime(true) - $start) < $maxDuration) {
                if (connection_aborted()) break;

                $now = time();
                if (($now - $lastSessionCheck) >= 3) {
                    $lastSessionCheck = $now;
                    $alive = Session::where('id', $sessionId)->where('status', 'active')->exists();
                    if (!$alive) {
                        echo "event: ended\n";
                        echo "data: {\"reason\":\"session_closed\"}\n\n";
                        @ob_flush(); flush();
                        break;
                    }
                }

                $participants = SessionParticipant::where('game_session_id', $sessionId)
                    ->with(['user:id,name,crystal_id,foto'])
                    ->get();

                $userIds = $participants->pluck('user_id')->unique()->all();

                // Última rolagem POR USUÁRIO (independe da ficha)
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
                        'name'       => (string) $u->name,
                        'crystal_id' => (string) $u->crystal_id,
                        'foto'       => $u->foto ? route('media.show', $u->foto) : null,
                        'is_master'  => $u->id === $masterUserId,
                        'last_dice'  => $r ? (string) $r->dice_result  : null,
                        'last_event' => $r ? (string) $r->event_result : null,
                        'updated_at' => $r ? (int) ($r->updated_at?->getTimestamp() ?? 0) : 0,
                    ];
                }

                usort($data, fn($a, $b) => $a['user_id'] <=> $b['user_id']);

                $hash = md5(json_encode($data, JSON_INVALID_UTF8_SUBSTITUTE | JSON_UNESCAPED_UNICODE));

                if ($hash !== $lastHash) {
                    $lastHash = $hash;
                    $payload = json_encode([
                        'in_session'   => true,
                        'session_code' => $sessionCode,
                        'participants' => $data,
                    ], JSON_INVALID_UTF8_SUBSTITUTE | JSON_UNESCAPED_UNICODE);

                    if ($payload !== false) {
                        echo "event: update\n";
                        echo "data: {$payload}\n\n";
                    }
                } else {
                    echo ": hb {$now}\n\n";
                }

                @ob_flush(); flush();
                usleep(300000);
            }
        }, 200, [
            'Content-Type'      => 'text/event-stream; charset=utf-8',
            'Cache-Control'     => 'no-cache, no-store, must-revalidate',
            'Pragma'            => 'no-cache',
            'X-Accel-Buffering' => 'no',
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