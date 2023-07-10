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
        Schema::create('amazon_factures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('amazon_commande_id');
            $table->timestamp('editee_le');
            $table->char('adresse_facturation', 255);
            $table->char('mode_paiement', 255);
            $table->double('montant_a_payer');
            $table->foreign('amazon_commande_id')->references('id')->on('amazon_commandes')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amazon_factures');
    }
};
