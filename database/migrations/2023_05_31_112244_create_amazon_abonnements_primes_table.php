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
        Schema::create('amazon_abonnements_primes', function (Blueprint $table) {
            $table->id();
            $table->string("libelle")->nullable(false);
            $table->string("formule")->nullable(false);
            $table->string("forfait")->nullable(false);
            $table->string("details")->nullable(false);
            $table->date("cree_le")->nullable(false);
            $table->date("modifie_le")->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amazon_abonnements_primes');
    }
};
