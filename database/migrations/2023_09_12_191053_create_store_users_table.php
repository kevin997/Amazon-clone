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
        Schema::create('store_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->char('nom', 100);
            $table->char('adresse', 255);
            $table->char('pays', 100)->nullable();
            $table->char('code_postal', 25)->nullable();
            $table->char('etat', 15)->default('En attente');
            $table->char('logo', 255);
            $table->char('site_web', 255);
            $table->timestamp('modifie_le')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_users');
    }
};
