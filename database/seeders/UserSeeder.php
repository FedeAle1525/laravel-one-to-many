<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Creo Utente per averlo gia' memorizzato in tabella in caso di 'fresh' o 'refresh' del DB
        $user = User::create([
            'name' => 'Fede',
            'email' => 'fede-1525@hotmail.it',
            'password' => Hash::make('fede1525'),
        ]);
    }
}
