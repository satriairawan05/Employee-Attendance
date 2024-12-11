<?php

namespace Database\Seeders;

use App\Enums\Statuses;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataName = ['Rendra', 'Khariz', 'Joko', 'Mariyam'];
        $dataEmail = ['rendragaluh@gmail.com', 'Kharizajaah@gmail.com', 'Jokoterdepan@gmail.com', 'Mariyamyuk@gmail.com'];

        for ($i = 0; $i < count($dataName); $i++) {
            \App\Models\User::create([
                'name' => $dataName[$i],
                'email' => $dataEmail[$i],
                'email_verified_at' => now(),
                'password' => \base64_encode('password'),
                'remember_token' => Str::random(10),
                'status' => Statuses::Active,
                'created_at' => '2012-12-12'
            ]);
        }
    }
}
