<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('roll_logs', function (Blueprint $table) {
            // Índice composto para acelerar "última rolagem por usuário"
            if (!$this->hasIndex('roll_logs', 'roll_logs_user_id_id_index')) {
                $table->index(['user_id', 'id'], 'roll_logs_user_id_id_index');
            }
            if (!$this->hasIndex('roll_logs', 'roll_logs_character_id_user_id_index')) {
                $table->index(['character_id', 'user_id'], 'roll_logs_character_id_user_id_index');
            }
        });
    }

    public function down(): void
    {
        Schema::table('roll_logs', function (Blueprint $table) {
            $table->dropIndex('roll_logs_user_id_id_index');
            $table->dropIndex('roll_logs_character_id_user_id_index');
        });
    }

    private function hasIndex(string $table, string $indexName): bool
    {
        $indexes = collect(\DB::select("SHOW INDEX FROM {$table}"))->pluck('Key_name')->unique();
        return $indexes->contains($indexName);
    }
};