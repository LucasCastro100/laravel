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
        Schema::create('permutas', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('contato_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('contato_nome')->nullable();
            $table->string('titulo')->nullable();
            $table->text('descricao')->nullable();
            $table->decimal('valor', 10, 2);
            $table->date('data')->nullable();
            $table->string('status')->default('concluida');
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['contato_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permutas');
    }
};
