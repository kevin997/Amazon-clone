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
        Schema::create('amazon_fournisseurs', function (Blueprint $table) {
            $table->id();
            $table->String("nom_complet")->nullable(false);
            $table->String("adresse")->nullable(false);
            $table->String("contact")->nullable(false);
            $table->String("pays_residence")->nullable(false);
            $table->String("site_web")->nullable(false);
            $table->String("secteur_activite")->nullable(false);
            $table->int("users_id")->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amazon_fournisseurs');
    }
};
