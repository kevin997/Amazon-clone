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
        Schema::create('amazon_produit_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('amazon_produit_id');
            $table->char('photo_1', 255);
            $table->char('photo_2', 255);
            $table->char('photo_3', 255);
            $table->char('photo_4', 255);
            $table->char('photo_5', 255);
            $table->char('video', 255);
            $table->timestamp('cree_le')->nullable();
            $table->timestamp('modifie_le')->nullable();
            $table->foreign('amazon_produit_id')->references('id')->on('amazon_produits')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amazon_produit_details');
    }
};
