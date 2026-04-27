<?php

namespace App\Http\ViewComposers;

use App\Models\SessionParticipant;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class SessionComposer
{
    public function compose(View $view)
    {
        $activeSession = null;
        if (Auth::check()) {
            $participant = SessionParticipant::where('user_id', Auth::id())
                ->with('session')
                ->first();
            if ($participant && $participant->session->status === 'active') {
                $activeSession = $participant->session;
            }
        }
        $view->with('activeSession', $activeSession);
    }
}