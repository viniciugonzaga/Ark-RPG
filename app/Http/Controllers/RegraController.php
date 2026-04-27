<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegraController extends Controller
{
    public function index()
    {
        // Certifique-se que o arquivo está em resources/views/regras/index.blade.php
        return view('regras.index');
    }

    public function download()
    {
        $file = public_path('pdfs/manual-ark.pdf');

        if (!file_exists($file)) {
            return redirect()->back()->with('error', 'Arquivo não encontrado no servidor.');
        }

        return response()->download($file, 'Manual-Ark-RPG.pdf');
    }
}