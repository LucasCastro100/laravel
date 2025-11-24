<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');            
            $table->json('answers');       // Salvar todas as respostas
            $table->json('scores');        // Somatória por canal
            $table->json('percentual');    // Percentual por canal
            $table->string('primary');     // Canal primário
            $table->string('secondary');   // Canal secundário
            $table->uuid()->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};
