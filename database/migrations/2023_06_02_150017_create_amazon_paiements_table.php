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
        Schema::create('amazon_paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('amazon_commande_id');
            $table->foreignId('amazon_user_bank_account_id')->nullable();
            $table->foreignId('amazon_user_credit_card_id')->nullable();
            $table->double('montant_paye');
            $table->char('details', 255);
            $table->timestamp('paye_le');
            $table->foreign('amazon_commande_id')->references('id')->on('amazon_commandes')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('amazon_user_bank_account_id')->references('id')->on('amazon_user_bank_accounts')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('amazon_user_credit_card_id')->references('id')->on('amazon_user_credit_cards')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amazon_paiements');
    }
};
