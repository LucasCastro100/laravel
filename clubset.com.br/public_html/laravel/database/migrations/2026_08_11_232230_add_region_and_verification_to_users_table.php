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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('state_id')->nullable()->after('current_team_id')->constrained('states')->nullOnDelete();
            $table->foreignId('municipality_id')->nullable()->after('state_id')->constrained('municipalities')->nullOnDelete();
            $table->timestamp('admin_verified_at')->nullable()->after('municipality_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('state_id');
            $table->dropConstrainedForeignId('municipality_id');
            $table->dropColumn('admin_verified_at');
        });
    }
};
