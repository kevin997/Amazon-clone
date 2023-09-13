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
        Schema::create('credit_card_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->char('numero_carte', 32);
            $table->timestamp('date_expiration')->nullable(false);
            $table->char('nom_proprietaire', 100);            
            $table->char('code_cvs', 3);
            $table->char('modele_carte', 25);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_card_users');
    }
};
