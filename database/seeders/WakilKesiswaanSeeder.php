<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WakilKesiswaan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class WakilKesiswaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Wakil Kesiswaan',
            'email' => 'afdal@gmail.com',
            'password' => Hash::make('afdal123'),
            'role' => 'wakil_kesiswaan',
        ]);

        WakilKesiswaan::create([
            'user_id' => $user->id,
            'nip' => '987654321',
        ]);
    }
}