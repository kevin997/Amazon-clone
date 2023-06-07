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
            $table->foreignId('amazon_panier_id');
            $table->timestamp('passee_le');
            $table->char('mode_livraison', 50);
            $table->char('adresse_livraison', 255);
            $table->char('delais_livraison', 25);
            $table->char('mode_paiement', 150);
            $table->char('etat', 25);
            $table->string('commentaires', 500);
            $table->double('frais_transport');
            $table->double('taux_tva');
            $table->double('montant_hors_taxes');            
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('amazon_panier_id')->references('id')->on('amazon_paniers')->cascadeOnDelete()->cascadeOnUpdate();
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
