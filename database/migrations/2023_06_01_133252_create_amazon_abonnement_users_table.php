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
        Schema::create('amazon_abonnement_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('amazon_abonnement_prime_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('amazon_abonnement_prime_id')->references('id')->on('amazon_abonnement_primes')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamp('souscris_le')->nullable();
            $table->timestamp('expire_le')->nullable();
            
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amazon_abonnement_users');
    }
};
