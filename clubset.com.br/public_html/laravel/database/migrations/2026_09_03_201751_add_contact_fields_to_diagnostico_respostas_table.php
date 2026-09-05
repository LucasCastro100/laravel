<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('diagnostico_respostas', function (Blueprint $table) {
            $table->string('nome');
            $table->string('instagram');
            $table->string('celular');
            $table->foreignId('state_id')->constrained();
            $table->foreignId('municipality_id')->constrained();
            $table->boolean('participa_grupo_whatsapp');
            $table->string('grupo_whatsapp_qual')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diagnostico_respostas', function (Blueprint $table) {
            $table->dropConstrainedForeignId('state_id');
            $table->dropConstrainedForeignId('municipality_id');
            $table->dropColumn([
                'nome',
                'instagram',
                'celular',
                'participa_grupo_whatsapp',
                'grupo_whatsapp_qual',
            ]);
        });
    }
};
