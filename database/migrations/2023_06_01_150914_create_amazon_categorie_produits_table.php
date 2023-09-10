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
        Schema::create('amazon_categorie_produits', function (Blueprint $table) {
            $table->id();
            $table->char('nom', 100);
            $table->text('details');
            $table->double('taxe_transport');
            $table->double('commission_vente');
            $table->timestamp('modifie_le')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amazon_categorie_produits');
    }
};
