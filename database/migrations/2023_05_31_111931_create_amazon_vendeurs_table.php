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
        Schema::create('amazon_vendeurs', function (Blueprint $table) {
            $table->id();
            $table->string("nom_complet")->nullable(false);
            $table->string("adresse")->nullable(false);
            $table->string("pays_residence")->nullable(false);
            $table->string("site_web")->nullable(false);
            $table->string("numero_registre_commerce")->nullable(false);
            $table->string("regime_taxes")->nullable(false);
            $table->string("photo")->nullable(false);
            $table->string("visuel_recto_piece_identite")->nullable(false);
            $table->string("visuel_verso_piece_identite")->nullable(false);
            $table->int("plan_ventes_id")->nullable(false);
            $table->int("users_id")->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amazon_vendeurs');
    }
};
