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
        Schema::create('message_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->constrained('messages')->onDelete('cascade'); // Relaciona com a tabela messages
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relaciona com a tabela users
            $table->timestamp('deleted_at')->nullable(); // Coluna para marcar quando o usuário deletou a mensagem
            $table->timestamps(); // Marcas de criação e atualização
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_users');
    }
};
