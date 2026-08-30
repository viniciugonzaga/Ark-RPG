<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fichas', function (Blueprint $table) {
            if (!Schema::hasColumn('fichas', 'is_pinned')) {
                $table->boolean('is_pinned')->default(false)->after('is_resgatada');
            }

            if (!Schema::hasColumn('fichas', 'background_image')) {
                $table->string('background_image')->nullable()->after('image');
            }
        });
    }

    public function down(): void
    {
        // Intencionalmente vazio para evitar perda de dados dos usuários.
    }
};