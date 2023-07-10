<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ForeignIdColumnDefinition;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('amazon_produits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('amazon_categorie_produit_id');
            $table->foreignId('amazon_store_id');
            $table->foreignId('user_id');
            $table->char('code_reference', 255);
            $table->char('code_barres', 255);
            $table->char('designation', 100);
            $table->double('prix_unitaire');
            $table->double('prix_unite_emballage');
            $table->double('taux_remise');
            $table->double('taux_tva');
            $table->double('frais_livraison');
            $table->bigInteger('seuil_reapprovisionnement');
            $table->bigInteger('niveau_alerte');
            $table->bigInteger('quantite_disponible');
            $table->char('details', 255);
            $table->char('etat', 25);
            $table->timestamp('cree_le')->nullable();
            $table->timestamp('modifie_le')->nullable();
            $table->foreign('amazon_categorie_produit_id')->references('id')->on('amazon_categorie_produits')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('amazon_store_id')->references('id')->on('amazon_stores')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amazon_produits');
    }
};
