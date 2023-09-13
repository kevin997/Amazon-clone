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
        Schema::create('categorie_produits', function (Blueprint $table) {
            $table->id();
            $table->char('name', 100);
            $table->string('details', 5000)->nullable();
            $table->double('frais_vente_min')->default(0.30);
            $table->double('frais_vente_max')->default(0.30);
            $table->double('frais_expedition')->default(0.30);
            $table->double('frais_stockage')->default(0.30);
            $table->double('frais_traitement_retour')->default(0.30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorie_produits');
    }
};
