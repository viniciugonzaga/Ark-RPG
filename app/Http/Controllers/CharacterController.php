<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CharacterController extends Controller
{
    public function index()
    {
        // Otimizado: Carrega os personagens do usuário com os dados essenciais para evitar queries N+1
        $characters = Auth::user()->characters()
            ->with(['mutations', 'bonuses', 'survivorPowers', 'rituals'])
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
            'custom_class_name' => 'nullable|string|max:255',
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

        if ($request->class_sub === 'nova' && $request->filled('custom_class_name')) {
            $data['class_sub'] = $request->custom_class_name;
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('characters', 'public');
        }

        $data['user_id'] = Auth::id();

        // Envolve em uma transação de banco de dados por segurança e velocidade
        $character = DB::transaction(function () use ($data, $request) {
            $char = Character::create($data);
            $this->syncRelationsBulk($char, $request);
            return $char;
        });

        return redirect()->route('fichas.show', $character->id)->with('success', 'Unidade Registrada.');
    }

    public function show($id)
    {
        $ficha = Character::with(['mutations', 'bonuses', 'survivorPowers', 'rituals'])
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
            if ($ficha->image) Storage::disk('public')->delete($ficha->image);
            $data['image'] = $request->file('image')->store('characters', 'public');
        }

        // Transação do Banco: Ou salva TUDO de uma vez de forma ultra rápida, ou não faz nada (evita dados corrompidos)
        DB::transaction(function () use ($ficha, $data, $request) {
            $ficha->update($data);

            // Deleta de forma direta e limpa no banco
            $ficha->mutations()->delete();
            $ficha->bonuses()->delete();
            $ficha->survivorPowers()->delete();
            $ficha->rituals()->delete();

            // Salva usando o novo método Bulk Otimizado
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
            Storage::disk('public')->delete($character->image);
        }

        $character->delete();

        return redirect()->route('fichas.index')->with('success', 'Unidade eliminada.');
    }

    /**
     * NOVO MÉTODO OTIMIZADO: Insere múltiplos dados com uma única query (Bulk Insert)
     */
    private function syncRelationsBulk(Character $character, Request $request)
    {
        $now = now();

        // 1. Otimização de Mutações
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
                $character->mutations()->insert($mutationsData); // 1 query apenas!
            }
        }

        // 2. Otimização de Bônus
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
                $character->bonuses()->insert($bonusesData); // 1 query apenas!
            }
        }

        // 3. Otimização de Rituais
        if ($request->has('rituals') && is_array($request->rituals)) {
            $ritualsData = [];
            foreach ($request->rituals as $ritual) {
                if (!empty($ritual['name'])) {
                    $ritualsData[] = [
                        'character_id' => $character->id,
                        'name'         => $ritual['name'],
                        'description'  => $ritual['description'] ?? null,
                        'created_at'   => $now,
                        'updated_at'   => $now,
                    ];
                }
            }
            if (!empty($ritualsData)) {
                $character->rituals()->insert($ritualsData); // 1 query apenas!
            }
        }

        // 4. Otimização de Poderes (Survivor Powers)
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
                $character->survivorPowers()->insert($powersData); // 1 query apenas!
            }
        }
    }
}