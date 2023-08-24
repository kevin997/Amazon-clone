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
        Schema::create('amazon_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produit_id');
            $table->double('quantite_disponible')->default(1);
            $table->char('saisi_par', 150);
            $table->foreign('produit_id')->references('id')->on('amazon_produits')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amazon_stocks');
    }
};
