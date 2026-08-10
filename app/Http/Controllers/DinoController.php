<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DinoController extends Controller
{
    public function saveRecord(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Não autenticado'], 401);
        }
        $request->validate(['record' => 'required|numeric|min:0']);

        if ($request->record > $user->dino_record) {
            $user->dino_record = $request->record;
            $user->save();
        }
        return response()->json(['success' => true, 'record' => $user->dino_record]);
    }

    public function getRecord(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['record' => 0, 'authenticated' => false]);
        }
        return response()->json(['record' => $user->dino_record ?? 0, 'authenticated' => true]);
    }
}