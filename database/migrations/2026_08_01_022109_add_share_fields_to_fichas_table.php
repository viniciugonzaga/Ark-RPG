<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fichas', function (Blueprint $table) {
            if (!Schema::hasColumn('fichas', 'is_resgatada')) {
                $table->boolean('is_resgatada')->default(false)->after('share_code');
            }
            if (!Schema::hasColumn('fichas', 'original_user_id')) {
                $table->foreignId('original_user_id')->nullable()->constrained('users')->after('is_resgatada');
            }
        });
    }

    public function down(): void
    {
        Schema::table('fichas', function (Blueprint $table) {
            $table->dropForeign(['original_user_id']);
            $table->dropColumn(['is_resgatada', 'original_user_id']);
        });
    }
};