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
        Schema::table('amazon_stores', function (Blueprint $table) {
            $table->char('pays', 100)->nullable();
            $table->char('code_postal', 25)->nullable();
            $table->char('etat', 15)->default('En attente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('amazon_stores', function (Blueprint $table) {
            //
        });
    }
};
