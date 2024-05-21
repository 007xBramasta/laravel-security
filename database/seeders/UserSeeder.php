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
     */
    public function run(): void
    {
        User::create([
            "name"=> "Bramasta Albatio",
            "email"=> "bram@localhost",
            "password"=> Hash::make('rahasia'),
            "token" => "secret"
        ]);

        User::create([
            "name"=> "Bramasta",
            "email"=> "bramasta@localhost",
            "password"=> Hash::make('rahasia123'),
            "token" => "secret"
        ]);
    }
}
