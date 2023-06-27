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
        Schema::create('amazon_annulation_commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('amazon_commande_id');
            $table->timestamp('annulee_le');
            $table->char('motif', 150);
            $table->foreign('amazon_commande_id')->references('id')->on('amazon_commandes')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amazon_annulation_commandes');
    }
};
