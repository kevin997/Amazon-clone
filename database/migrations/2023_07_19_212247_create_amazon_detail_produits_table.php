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
        Schema::create('amazon_detail_produits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produit_id');
            $table->longText('description');
            $table->char('photo_1', 255)->nullable();
            $table->char('photo_2', 255)->nullable();
            $table->char('photo_3', 255)->nullable();
            $table->char('photo_4', 255)->nullable();
            $table->char('photo_5', 255)->nullable();
            $table->char('video_explained', 255)->nullable();
            $table->foreign('produit_id')->references('id')->on('amazon_produits')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amazon_detail_produits');
    }
};
