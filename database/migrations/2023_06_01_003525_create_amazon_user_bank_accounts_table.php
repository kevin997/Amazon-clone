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
        Schema::create('amazon_user_bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->char('code_bank', 5);
            $table->char('code_guichet', 5);
            $table->char('numero_compte', 11);
            $table->char('cle_rib', 2);
            $table->char('code_bic', 11);
            $table->char('code_iban', 27);
            $table->char('nom_titulaire', 100);
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amazon_user_bank_accounts');
    }
};
