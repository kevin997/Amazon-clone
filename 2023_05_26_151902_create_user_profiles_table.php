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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->char('phone_number', 50);
            $table->foreignId('user_id');
            $table->timestamp('phone_number_verified_at')->nullable();
            $table->char('country', 50);
            $table->char('city', 50);
            $table->char('street_address', 255);
            $table->char('zip', 50);
            $table->text('profile_image');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
