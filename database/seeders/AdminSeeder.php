<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // creation d'un admin (1er compte utilisateur) 
        $user = User::create([
            'name' => "Admin",
            'email' => "admin@app.amazon.com",
            'email_verified_at' => now(),
            'password' => Hash::make('amazonClone@2023'), // password
        ]);

        $user->assignRole(['Admin', 'Guest', 'Customer', 'Seller']);
    }
}
