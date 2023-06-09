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
        Schema::create('amazon_detail_entree_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('amazon_produit_id');
            $table->foreignId('amazon_entree_stock_id');
            $table->double('quantite_entree');
            $table->timestamp('date_peremption')->nullable();
            $table->foreign('amazon_produit_id')->references('id')->on('amazon_produits')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('amazon_entree_stock_id')->references('id')->on('amazon_entree_stocks')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amazon_detail_entree_stocks');
    }
};
