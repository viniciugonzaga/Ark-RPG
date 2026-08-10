<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CharacterController extends Controller
{
    private function getStorageDisk()
    {
        return config('filesystems.image_disk', 'public');
    }

    public function index()
    {
        $characters = Auth::user()->characters()
            ->with(['mutations', 'bonuses', 'survivorPowers', 'rituals', 'originalUser'])
            ->latest()
            ->get();

        return view('fichas.index', compact('characters'));
    }

    public function create()
    {
        return view('fichas.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'level' => 'required|integer|min:1',
            'age' => 'nullable|integer',
            'class_main' => 'required|string',
            'class_sub' => 'nullable|string',
            'lore' => 'nullable|string',
            'arsenal' => 'nullable|string',
            'agi' => 'required|integer|min:0',
            'for' => 'required|integer|min:0',
            'int' => 'required|integer|min:0',
            'set' => 'required|integer|min:0',
            'vig' => 'required|integer|min:0',
            'vida' => 'nullable|integer',
            'armadura' => 'nullable|integer',
            'determinacao' => 'nullable|integer',
            'folego' => 'nullable|integer',
            'resistencia' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            $disk = $this->getStorageDisk();
            $path = $request->file('image')->store('characters', $disk);
            $data['image'] = $path;
        }

        $data['user_id'] = Auth::id();

        $character = DB::transaction(function () use ($data, $request) {
            $char = Character::create($data);
            $this->syncRelationsBulk($char, $request);
            return $char;
        });

        return redirect()->route('fichas.show', $character->id)->with('success', 'Unidade Registrada.');
    }

    public function show($id)
    {
        $ficha = Character::with(['mutations', 'bonuses', 'survivorPowers', 'rituals', 'user', 'originalUser'])
                          ->findOrFail($id);

        if ($ficha->user_id !== Auth::id()) abort(403, 'Acesso negado a Ficha.');

        return view('fichas.show', compact('ficha'));
    }

    public function edit($id)
    {
        $ficha = Character::with(['mutations', 'bonuses', 'survivorPowers', 'rituals'])
                          ->findOrFail($id);

        if ($ficha->user_id !== Auth::id()) abort(403);

        return view('fichas.edit', compact('ficha'));
    }

    public function update(Request $request, $id)
    {
        $ficha = Character::findOrFail($id);
        
        if ($ficha->user_id !== Auth::id()) abort(403);

        $data = $request->except(['mutations', 'bonuses', 'powers', 'rituals', 'image']);

        if ($request->hasFile('image')) {
            $disk = $this->getStorageDisk();
            if ($ficha->image) {
                Storage::disk($disk)->delete($ficha->image);
            }
            $path = $request->file('image')->store('characters', $disk);
            $data['image'] = $path;
        }

        DB::transaction(function () use ($ficha, $data, $request) {
            $ficha->update($data);

            $ficha->mutations()->delete();
            $ficha->bonuses()->delete();
            $ficha->survivorPowers()->delete();
            $ficha->rituals()->delete();

            $this->syncRelationsBulk($ficha, $request);
        });

        return redirect()->route('fichas.show', $ficha->id)->with('success', 'DNA Reconfigurado.');
    }

    public function destroy($id)
    {
        $character = Character::findOrFail($id);

        if ($character->user_id !== Auth::id()) {
            abort(403, 'Ação não autorizada.');
        }

        if ($character->image) {
            Storage::disk($this->getStorageDisk())->delete($character->image);
        }

        $character->delete();

        return redirect()->route('fichas.index')->with('success', 'Unidade eliminada.');
    }

    // ========== COMPARTILHAMENTO ==========
    public function share($id)
    {
        $ficha = Character::findOrFail($id);
        if ($ficha->user_id !== Auth::id()) {
            abort(403, 'Você não é o dono desta ficha.');
        }
        $code = $ficha->share();
        return response()->json(['code' => $code]);
    }

    /**
     * Resgatar uma ficha compartilhada
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

    // ========== MÉTODO AUXILIAR ==========
    private function syncRelationsBulk(Character $character, Request $request)
    {
        $now = now();

        if ($request->has('mutations') && is_array($request->mutations)) {
            $mutationsData = [];
            foreach ($request->mutations as $mut) {
                if (!empty($mut['name'])) {
                    $mutationsData[] = [
                        'character_id' => $character->id,
                        'origin'       => $mut['origin'] ?? null,
                        'name'         => $mut['name'],
                        'description'  => $mut['description'] ?? null,
                        'created_at'   => $now,
                        'updated_at'   => $now,
                    ];
                }
            }
            if (!empty($mutationsData)) {
                $character->mutations()->insert($mutationsData);
            }
        }

        if ($request->has('bonuses') && is_array($request->bonuses)) {
            $bonusesData = [];
            foreach ($request->bonuses as $bonus) {
                if (!empty($bonus['name'])) {
                    $bonusesData[] = [
                        'character_id' => $character->id,
                        'name'         => $bonus['name'],
                        'value'        => $bonus['value'] ?? 0,
                        'created_at'   => $now,
                        'updated_at'   => $now,
                    ];
                }
            }
            if (!empty($bonusesData)) {
                $character->bonuses()->insert($bonusesData);
            }
        }

        if ($request->has('rituals') && is_array($request->rituals)) {
            $ritualsData = [];
            foreach ($request->rituals as $ritual) {
                if (!empty($ritual['name'])) {
                    $ritualsData[] = [
                        'character_id' => $character->id,
                        'name'         => $ritual['name'],
                        'description'  => $ritual['description'] ?? null,
                        'type'         => $ritual['type'] ?? 'ritual',
                        'created_at'   => $now,
                        'updated_at'   => $now,
                    ];
                }
            }
            if (!empty($ritualsData)) {
                $character->rituals()->insert($ritualsData);
            }
        }

        if ($request->has('powers') && is_array($request->powers)) {
            $powersData = [];
            foreach ($request->powers as $power) {
                if (!empty($power['name'])) {
                    $powersData[] = [
                        'character_id' => $character->id,
                        'name'         => $power['name'],
                        'description'  => $power['description'] ?? null,
                        'created_at'   => $now,
                        'updated_at'   => $now,
                    ];
                }
            }
            if (!empty($powersData)) {
                $character->survivorPowers()->insert($powersData);
            }
        }
    }
}