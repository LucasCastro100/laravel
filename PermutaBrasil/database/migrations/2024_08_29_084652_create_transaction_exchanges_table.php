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
        Schema::create('transaction_exchanges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('extract_id')->constrained();     
            $table->date('start_date');
            $table->string('end_date');
            $table->decimal('value');
            $table->integer('status');
            $table->integer('type_payment')->nullable();
            $table->string('proof_payment');
            $table->string('contract')->nullable();
            $table->string('description');
            $table->uuid();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_exchanges');
    }
};
