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
        Schema::create('paniers_produits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('panier_id');
            $table->foreignId('produit_id');
            $table->double('quantite_commandee')->default(1.00);
            $table->double('prix_vente')->default(1.00);
            $table->foreign('panier_id')->references('id')->on('paniers')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('produit_id')->references('id')->on('produits')->cascadeOnDelete()->cascadeOnUpdate();            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paniers_produits');
    }
};
