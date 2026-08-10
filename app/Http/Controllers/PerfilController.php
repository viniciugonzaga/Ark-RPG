<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $fichas = $user->characters; // Relacionamento definido no User

        return view('perfil', compact('user', 'fichas'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $user->update($request->only('name', 'email'));

        return back()->with('status', 'Bio-dados atualizados com sucesso.');
    }
}