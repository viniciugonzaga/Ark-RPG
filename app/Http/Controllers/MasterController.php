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
        return view('master.mesa');
    }

    public function buscarJogador($crystalId)
    {
        if (Auth::user()->cargo !== 'mestre') {
            abort(403);
        }

        $user = User::where('crystal_id', $crystalId)->firstOrFail();
        $rollLog = RollLog::where('user_id', $user->id)->first();

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'crystal_id' => $user->crystal_id,
            ],
            'last_roll' => [
                'dice' => ($rollLog && $rollLog->dice_result) ? $rollLog->dice_result : 'Nenhuma rolagem',
                'event' => ($rollLog && $rollLog->event_result) ? $rollLog->event_result : 'Nenhum evento',
                'created_at' => $rollLog ? $rollLog->created_at->diffForHumans() : null,
            ]
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

    public function getParticipantesComRolagens($code)
    {
        if (Auth::user()->cargo !== 'mestre') {
            abort(403);
        }

        $session = Session::where('session_code', $code)
            ->where('status', 'active')
            ->firstOrFail();

        $participants = $session->participants()->with('user')->get();
        $data = [];

        foreach ($participants as $participant) {
            $user = $participant->user;
            $rollLog = RollLog::where('user_id', $user->id)->first();

            $data[] = [
                'name' => $user->name,
                'crystal_id' => $user->crystal_id,
                'last_dice' => ($rollLog && $rollLog->dice_result) ? $rollLog->dice_result : 'Nenhuma rolagem',
                'last_event' => ($rollLog && $rollLog->event_result) ? $rollLog->event_result : 'Nenhum evento',
                'last_time' => $rollLog ? $rollLog->created_at->diffForHumans() : null,
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