<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Panitia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PanitiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Panitia',
            'email' => 'panitia@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'panitia',
        ]);

        Panitia::create([
            'user_id' => $user->id,
        ]);
    }
}