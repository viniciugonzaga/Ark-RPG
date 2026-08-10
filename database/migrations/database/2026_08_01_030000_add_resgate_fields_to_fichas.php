<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function resgatar(Request $request)
{
    $request->validate([
        'code' => 'required|string|exists:fichas,share_code',
    ]);

    // Carrega a ficha original com TODOS os relacionamentos que serão clonados
    $original = Character::with(['mutations', 'bonuses', 'survivorPowers', 'rituals'])
                ->where('share_code', $request->code)
                ->firstOrFail();

    // Impedir que o próprio dono resgate
    if ($original->user_id === Auth::id()) {
        return back()->with('error', 'Você já é o dono desta ficha.');
    }

    // Clonar a ficha
    $nova = $original->replicate();
    $nova->user_id = Auth::id();
    $nova->share_code = null;
    $nova->is_resgatada = true;
    $nova->original_user_id = $original->user_id;
    $nova->save();

    // Copiar relacionamentos (agora com segurança)
    $relacoes = ['mutations', 'bonuses', 'survivorPowers', 'rituals'];
    foreach ($relacoes as $rel) {
        // Verificação extra para evitar erro (opcional, mas seguro)
        if ($original->$rel) {
            foreach ($original->$rel as $item) {
                $newItem = $item->replicate();
                $newItem->character_id = $nova->id;
                $newItem->save();
            }
        }
    }

    return redirect()->route('fichas.show', $nova->id)
                     ->with('success', 'Ficha resgatada com sucesso!');
}
};