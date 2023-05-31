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
        Schema::create('amazon_clients', function (Blueprint $table) {
            $table->id();
            $table->string("nom_complet")->nullable(false);
            $table->string("adresse")->nullable(false);
            $table->date("date_naissance")->nullable(false);
            $table->string("lieu_naissance")->nullable(false);
            $table->string("pays_residence")->nullable(false);
            $table->string("photo")->nullable(false);
            $table->string("type_piece_identite")->nullable(false);
            $table->string("numero_piece_identite")->nullable(false);
            $table->date("date_expiration_piece_identite")->nullable(false);
            $table->int("users_id")->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amazon_clients');
    }
};
