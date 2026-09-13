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

        $rollLog = RollLog::where('character_id', $id)
            ->where('user_id', auth()->id())
            ->first();

        return response()->json([
            'char' => array_merge($char->toArray(), [
                'arsenal' => $this->normalizeArsenal($char->arsenal),
            ]),
            'lastRoll' => $rollLog ? [
                'dice_result' => $rollLog->dice_result,
                'event_result' => $rollLog->event_result,
            ] : null,
        ]);
    }

    public function saveRoll(Request $request)
    {
        $request->validate([
            'character_id' => 'required',
            'dice_result' => 'nullable',
            'event_result' => 'nullable',
        ]);

        $rollLog = RollLog::firstOrNew([
            'character_id' => $request->character_id,
            'user_id' => auth()->id(),
        ]);

        if ($request->has('dice_result') && !is_null($request->dice_result)) {
            $rollLog->dice_result = $request->dice_result;
        }
        if ($request->has('event_result') && !is_null($request->event_result)) {
            $rollLog->event_result = $request->event_result;
        }
        $rollLog->save();

        return response()->json(['status' => 'ok']);
    }

    public function saveWeapon(Request $request)
    {
        $request->validate([
            'character_id' => ['required', 'exists:fichas,id'],
            'weapon.name' => ['required', 'string', 'max:120'],
            'weapon.hit' => ['nullable', 'string', 'max:30'],
            'weapon.damage' => ['nullable', 'string', 'max:30'],
        ]);

        $character = Character::where('user_id', auth()->id())
            ->findOrFail($request->character_id);

        $weapons = $this->normalizeArsenal($character->arsenal);
        $name = trim((string) $request->input('weapon.name'));
        $hit = trim((string) $request->input('weapon.hit'));
        $damage = trim((string) $request->input('weapon.damage'));

        if ($name === '') {
            return response()->json(['message' => 'O nome da arma é obrigatório.'], 422);
        }

        if ($hit === '' && $damage === '') {
            return response()->json(['message' => 'Informe ao menos um campo de acerto ou dano.'], 422);
        }

        $normalizedWeapon = [
            'name' => $name,
            'hit' => $hit,
            'damage' => $damage,
        ];

        $existingIndex = null;
        foreach ($weapons as $index => $weapon) {
            if (isset($weapon['name']) && strtolower(trim($weapon['name'])) === strtolower($name)) {
                $existingIndex = $index;
                break;
            }
        }

        if ($existingIndex !== null) {
            $weapons[$existingIndex] = $normalizedWeapon;
        } else {
            $weapons[] = $normalizedWeapon;
        }

        $character->arsenal = $weapons;
        $character->save();

        return response()->json([
            'status' => 'ok',
            'arsenal' => $weapons,
        ]);
    }

    private function normalizeArsenal($arsenal): array
    {
        if (is_array($arsenal)) {
            return array_values(array_filter($arsenal, fn ($weapon) => is_array($weapon) || is_object($weapon)));
        }

        if (empty($arsenal)) {
            return [];
        }

        $decoded = json_decode((string) $arsenal, true);
        return is_array($decoded) ? array_values($decoded) : [];
    }
}