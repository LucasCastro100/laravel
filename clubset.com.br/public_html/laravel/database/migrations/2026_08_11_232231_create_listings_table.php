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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->string('category');
            $table->string('condition')->nullable();
            $table->string('intent')->default('ofereco');
            $table->string('type')->default('ambos');
            $table->decimal('price', 10, 2)->nullable();
            $table->string('currency', 3)->default('brl');
            $table->foreignId('state_id')->nullable()->constrained('states')->nullOnDelete();
            $table->foreignId('municipality_id')->nullable()->constrained('municipalities')->nullOnDelete();
            $table->string('status')->default('pending');
            $table->text('moderation_reason')->nullable();
            $table->timestamps();

            $table->index(['status', 'state_id']);
            $table->index(['category', 'intent']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
