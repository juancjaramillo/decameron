<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'prueba@prueba.com'],
            [
                'name'     => 'Usuario Prueba',
                'password' => Hash::make('prueba123'),
            ]
        );
    }
}
