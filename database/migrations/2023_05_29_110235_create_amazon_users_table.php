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
        Schema::create('amazon_users', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->string('pseudo', 32);
            $table->string('motpasse', 32);
            $table->string('email', 255);
            $table->string('contact', 15);
            $table->string('statut', 1);
            $table->date('cree_le');
            $table->date('modifie_le');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amazon_users');
    }
};
