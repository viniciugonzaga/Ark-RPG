<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\RollLog;
use Illuminate\Http\Request;

class RollController extends Controller
{
    public function index()
    {
        $characters = Character::where('user_id', auth()->id())->get();
        return view('roll.index', compact('characters'));
    }

    public function loadCharacter($id)
    {
        $char = Character::with(['mutations', 'bonuses'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        // Busca o registro único de rolagem para esta ficha
        $rollLog = RollLog::where('character_id', $id)
            ->where('user_id', auth()->id())
            ->first();

        return response()->json([
            'char' => $char,
            'lastRoll' => $rollLog ? [
                'dice_result' => $rollLog->dice_result,
                'event_result' => $rollLog->event_result,
            ] : null
        ]);
    }

    public function saveRoll(Request $request)
    {
        $request->validate([
            'character_id' => 'required',
            'dice_result' => 'nullable',
            'event_result' => 'nullable',
        ]);

        // Busca ou cria um único registro para esta ficha
        $rollLog = RollLog::firstOrNew([
            'character_id' => $request->character_id,
            'user_id' => auth()->id(),
        ]);

        // Atualiza apenas o campo correspondente à rolagem
        if ($request->has('dice_result') && !is_null($request->dice_result)) {
            $rollLog->dice_result = $request->dice_result;
        }
        if ($request->has('event_result') && !is_null($request->event_result)) {
            $rollLog->event_result = $request->event_result;
        }
        $rollLog->save();

        return response()->json(['status' => 'ok']);
    }
}