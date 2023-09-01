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
        Schema::create('amazon_commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('user_profile_id');
            $table->foreignId('tva_id')->default(0.01);
            $table->char('mode_paiement', 25);
            $table->char('mode_livraison', 25);
            $table->float('frais_expedition')->default(0.99);
            $table->char('etat', 10);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('user_profile_id')->references('id')->on('user_profiles')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('tva_id')->references('id')->on('amazon_tva')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amazon_commandes');
    }
};
