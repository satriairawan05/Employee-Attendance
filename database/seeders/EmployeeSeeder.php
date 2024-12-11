<?php

namespace Database\Seeders;

use App\Enums\Statuses;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataDoB = ['2011-11-11', '2012-12-12', '2010-10-10', '2009-09-09'];
        $dataCity = ['Jogja', 'Bantul', 'Sleman', 'Gunung Kidul'];

        for($i = 0; $i < count($dataDoB); $i++)
        {
            \App\Models\Employee::create([
                'dob' => $dataDoB[$i],
                'city' => $dataCity[$i],
                'user_id' => $i + 1,
                'status' => Statuses::Active,
                'created_at' => '2012-12-12'
            ]);
        }
    }
}
