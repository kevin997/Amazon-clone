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
        Schema::create('amazon_detail_commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('amazon_commande_id');
            $table->foreignId('amazon_produit_id');            
            $table->double('prix_vente');
            $table->double('taux_remise');
            $table->double('quantite_commandee');            
            $table->foreign('amazon_commande_id')->references('id')->on('amazon_commandes')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('amazon_produit_id')->references('id')->on('amazon_produits')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amazon_detail_commandes');
    }
};
