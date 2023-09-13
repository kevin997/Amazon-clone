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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categorie_produit_id');
            $table->foreignId('store_user_id');
            $table->char('designation', 255);
            $table->char('unite_emballage', 25);
            $table->char('devise', 25);
            $table->char('etat', 25);
            $table->double('niveau_alerte');
            $table->double('seuil_recompletement');            
            $table->foreign('categorie_produit_id')->references('id')->on('categorie_produits')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('store_user_id')->references('id')->on('store_users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
