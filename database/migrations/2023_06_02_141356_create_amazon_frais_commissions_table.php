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
        Schema::create('amazon_frais_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('amazon_commande_id');            
            $table->char('objet', 100);
            $table->double('montant_preleve');
            $table->timestamp('effectuee_le');
            $table->foreign('amazon_commande_id')->references('id')->on('amazon_commandes')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amazon_frais_commissions');
    }
};
