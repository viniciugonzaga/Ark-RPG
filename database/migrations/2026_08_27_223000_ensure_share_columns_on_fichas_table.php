<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fichas', function (Blueprint $table) {
            if (!Schema::hasColumn('fichas', 'share_code')) {
                $table->string('share_code')->nullable()->unique()->after('user_id');
            }

            if (!Schema::hasColumn('fichas', 'is_resgatada')) {
                $table->boolean('is_resgatada')->default(false)->after('share_code');
            }

            if (!Schema::hasColumn('fichas', 'original_user_id')) {
                $table->foreignId('original_user_id')->nullable()->constrained('users')->after('is_resgatada');
            }

            if (!Schema::hasColumn('fichas', 'original_character_id')) {
                $table->foreignId('original_character_id')->nullable()->constrained('fichas')->nullOnDelete()->after('original_user_id');
            }
        });
    }

    public function down(): void
    {
        // Intencionalmente vazio para evitar perda de dados de compartilhamento/resgate.
    }
};