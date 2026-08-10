<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\RollLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasterController extends Controller
{
    public function index()
    {
        if (Auth::user()->cargo !== 'mestre') {
            abort(403, 'Apenas mestres podem acessar esta área.');
        }

        // Verifica se já existe uma mesa ativa para este mestre
        $activeSession = Session::where('master_user_id', Auth::id())
            ->where('status', 'active')
            ->first();

        $mesaCode = $activeSession ? $activeSession->session_code : null;

        return view('master.mesa', compact('mesaCode'));
    }

    /**
     * Busca jogador pelo ID de Cristal com a última rolagem
     * Otimizado com índices e consulta única
     */
    public function buscarJogador($crystalId)
    {
        if (Auth::user()->cargo !== 'mestre') {
            abort(403);
        }

        $user = User::where('crystal_id', $crystalId)->firstOrFail();

        // Busca o último log de uma vez (com índice, fica rápido)
        $rollLog = RollLog::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'crystal_id' => $user->crystal_id,
                'foto' => $user->foto ? asset('storage/' . $user->foto) : null,
            ],
            'last_roll' => $rollLog ? [
                'dice' => $rollLog->dice_result ?? 'Nenhuma rolagem',
                'event' => $rollLog->event_result ?? 'Nenhum evento',
                'created_at' => $rollLog->created_at->diffForHumans(),
            ] : null
        ]);
    }

    public function criarMesa(Request $request)
    {
        if (Auth::user()->cargo !== 'mestre') {
            abort(403);
        }

        // Verifica se já existe uma mesa ativa para este mestre
        $activeSession = Session::where('master_user_id', Auth::id())
            ->where('status', 'active')
            ->first();

        if ($activeSession) {
            return redirect()->route('master.mesa')->with('error', 'Você já possui uma mesa ativa. Encerre-a antes de criar outra.');
        }

        $session = Session::create([
            'master_user_id' => Auth::id(),
            'status' => 'active'
        ]);

        $session->participants()->create(['user_id' => Auth::id()]);

        return redirect()->route('master.sessao', $session->session_code);
    }

    public function showSessao($code)
    {
        if (Auth::user()->cargo !== 'mestre') {
            abort(403);
        }

        $session = Session::where('session_code', $code)
            ->where('status', 'active')
            ->firstOrFail();

        if ($session->master_user_id !== Auth::id()) {
            abort(403, 'Você não é o mestre desta mesa.');
        }

        return view('master.sessao', compact('session'));
    }

    /**
     * Retorna todos os participantes da sessão com suas últimas rolagens
     * Otimizado com agrupamento para evitar N+1
     */
    public function getParticipantesComRolagens($code)
    {
        if (Auth::user()->cargo !== 'mestre') {
            abort(403);
        }

        $session = Session::where('session_code', $code)
            ->where('status', 'active')
            ->firstOrFail();

        // Carrega todos os participantes com seus usuários
        $participants = $session->participants()
            ->with(['user' => function ($query) {
                $query->select('id', 'name', 'crystal_id', 'foto');
            }])
            ->get();

        // Busca a última rolagem de cada usuário em uma única consulta
        $userIds = $participants->pluck('user_id')->unique();
        $lastRolls = RollLog::whereIn('user_id', $userIds)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('user_id')
            ->map(fn($logs) => $logs->first());

        $data = [];
        foreach ($participants as $participant) {
            $user = $participant->user;
            $roll = $lastRolls->get($user->id);
            $data[] = [
                'id' => $user->id,
                'name' => $user->name,
                'crystal_id' => $user->crystal_id,
                'foto' => $user->foto ? asset('storage/' . $user->foto) : null,
                'last_dice' => $roll ? $roll->dice_result : 'Nenhuma rolagem',
                'last_event' => $roll ? $roll->event_result : 'Nenhum evento',
                'last_time' => $roll ? $roll->created_at->diffForHumans() : null,
            ];
        }

        return response()->json(['participants' => $data]);
    }

    public function encerrarMesa($code)
    {
        if (Auth::user()->cargo !== 'mestre') {
            abort(403);
        }

        $session = Session::where('session_code', $code)
            ->where('master_user_id', Auth::id())
            ->firstOrFail();

        $session->status = 'closed';
        $session->save();

        // Remove todos os participantes
        $session->participants()->delete();

        return redirect()->route('master.mesa')->with('success', 'Mesa encerrada com sucesso.');
    }
}