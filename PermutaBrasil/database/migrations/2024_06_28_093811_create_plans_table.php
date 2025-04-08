<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //automação de dados a cada 7 dias - campo advertencia para quando alacancar um valor ela cai de nivel
    //quantidade de vagas

    //bronze - permuta entre empresas - 
    //prata - permuta entre empresas e terceiros
    //ouro - 
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_description');
            $table->integer('price');
            $table->uuid();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
