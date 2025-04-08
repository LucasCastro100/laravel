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
        Schema::create('extracts', function (Blueprint $table) {
            $table->id();
            $table->date('date_service');
            $table->decimal('value_total')->nullable();
            $table->decimal('value_exchange');
            $table->decimal('transaction_financial');
            $table->string('service_product');                        
            $table->text('description')->nullable();
            $table->unsignedBigInteger('service_provider_id');
            $table->unsignedBigInteger('service_taker_id')->nullable();
            $table->foreign('service_provider_id')->references('id')->on('users');
            $table->foreign('service_taker_id')->references('id')->on('users');
            $table->boolean('verified')->default(false);
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
        Schema::dropIfExists('extracts');
    }
};
