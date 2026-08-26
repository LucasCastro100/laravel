<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            // Remove a coluna antiga
            $table->dropColumn('image');

            // Adiciona as novas colunas
            $table->string('image_cover')->nullable()->after('certificate');
            $table->string('image_banner')->nullable()->after('image_cover');
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            // Reverte as alterações caso precise dar um rollback
            $table->dropColumn(['image_cover', 'image_banner']);
            $table->string('image')->nullable()->after('certificate');
        });
    }
};
