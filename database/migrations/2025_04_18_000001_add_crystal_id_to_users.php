<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up()
    {
        // 1. Adiciona a coluna crystal_id se ela não existir
        if (!Schema::hasColumn('users', 'crystal_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('crystal_id')->unique()->nullable()->after('id');
            });
        } else {
            // Se a coluna já existe mas pode não ter índice único, tentamos adicionar
            if (!Schema::hasIndex('users', 'users_crystal_id_unique')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->unique('crystal_id');
                });
            }
        }

        // 2. Preenche os valores nulos com IDs de cristal únicos
        $users = DB::table('users')->whereNull('crystal_id')->get();
        foreach ($users as $user) {
            $crystalId = $this->generateUniqueCrystalId();
            DB::table('users')->where('id', $user->id)->update(['crystal_id' => $crystalId]);
        }

        // 3. Torna a coluna NOT NULL (se ainda não for)
        $column = Schema::getColumnListing('users');
        // Verifica se a coluna permite nulos; se sim, altera
        // Uma forma simples: tenta alterar, se falhar, ignora
        try {
            Schema::table('users', function (Blueprint $table) {
                $table->string('crystal_id')->nullable(false)->change();
            });
        } catch (\Exception $e) {
            // A coluna já pode ser NOT NULL, ignoramos erro
        }
    }

    public function down()
    {
        if (Schema::hasColumn('users', 'crystal_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('crystal_id');
            });
        }
    }

    private function generateUniqueCrystalId()
    {
        do {
            $crystal = 'CRY-' . strtoupper(Str::random(8));
        } while (DB::table('users')->where('crystal_id', $crystal)->exists());
        return $crystal;
    }
};