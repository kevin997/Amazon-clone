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
        Schema::create('amazon_paniers', function (Blueprint $table) {
            $table->id();
            $table->char('etat', 1);
            $table->char('devise', 25);
            $table->double('montant_total');
            $table->timestamp('modifie_le')->nullable();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amazon_paniers');
    }
};
