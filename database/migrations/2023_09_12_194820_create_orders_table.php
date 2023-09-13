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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('panier_id');
            $table->foreignId('tva_grid_id')->default(0.01);
            $table->char('mode_paiement', 25);
            $table->char('mode_livraison', 25);
            $table->float('frais_expedition')->default(0.99);
            $table->char('etat', 10);
            $table->timestamps();
            $table->foreign('panier_id')->references('id')->on('paniers')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('tva_grid_id')->references('id')->on('tva_grids')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
