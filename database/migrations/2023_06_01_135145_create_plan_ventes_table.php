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
        Schema::create('plan_ventes', function (Blueprint $table) {
            $table->id();
            $table->double('forfait');
            $table->double('frais_additionnels');
            $table->char('details', 150);
            $table->timestamp('cree_le')->nullable();
            $table->timestamp('modifie_le')->nullable();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_ventes');
    }
};
