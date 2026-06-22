<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->string('stripe_payment_intent_id')->unique();
            $table->string('stripe_charge_id')->nullable();

            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');

            $table->integer('amount'); // em centavos
            $table->string('currency', 10)->default('brl');
            $table->string('status'); // pending, succeeded, failed

            $table->json('installments')->nullable(); 

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
