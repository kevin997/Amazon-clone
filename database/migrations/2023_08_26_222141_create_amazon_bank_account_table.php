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
        Schema::create('amazon_bank_account', function (Blueprint $table) {
            $table->id();
            $table->char('code_bic', 11);
            $table->char('code_iban', 34);
            $table->char('nom_titulaire', 150);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amazon_bank_account');
    }
};
