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

    public function getMinhaSessao(Request $request)
    {
        $user = Auth::user();
        $participant = SessionParticipant::where('user_id', $user->id)
            ->with('session.master')
            ->first();

        if (!$participant || $participant->session->status !== 'active') {
            return response()->json(['in_session' => false]);
        }

        $session = $participant->session;
        $participants = $session->participants()->with('user')->get();

        $userIds = $participants->pluck('user_id')->unique();
        $lastRolls = RollLog::whereIn('user_id', $userIds)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('user_id')
            ->map(fn($logs) => $logs->first());

        $data = [];
        foreach ($participants as $p) {
            $u = $p->user;
            $roll = $lastRolls->get($u->id);
            $data[] = [
                'name' => $u->name,
                'crystal_id' => $u->crystal_id,
                'foto' => $u->foto ? route('media.show', $u->foto) : null, // CORRIGIDO
                'last_dice' => $roll ? $roll->dice_result : 'Nenhuma rolagem',
                'last_event' => $roll ? $roll->event_result : 'Nenhum evento',
                'is_master' => ($u->id === $session->master_user_id),
            ];
        }

        return response()->json([
            'in_session' => true,
            'session_code' => $session->session_code,
            'participants' => $data
        ]);
    }

    public function sair()
    {
        $user = Auth::user();
        $participant = SessionParticipant::where('user_id', $user->id)
            ->with('session')
            ->first();

        if ($participant && $participant->session->status === 'active') {
            $participant->delete();
        }

        return redirect()->route('rolagens.index')->with('success', 'Você saiu da sessão.');
    }
}