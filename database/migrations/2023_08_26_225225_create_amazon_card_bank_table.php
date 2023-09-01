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
        Schema::create('amazon_card_bank', function (Blueprint $table) {
            $table->id();
            $table->char('nom_titulaire', 150);
            $table->char('code_secret', 4);
            $table->char('type_carte', 25);
            $table->char('devise', 50);            
            $table->date('date_expiration');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amazon_card_bank');
    }
};
