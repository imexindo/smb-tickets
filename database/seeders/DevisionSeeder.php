<?php

namespace Database\Seeders;

use App\Models\Devision;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DevisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Devision::insert([
            [
                'name' => 'Accounting',
                'created_at' => now(),
            ],
            [
                'name' => 'Operational',
                'created_at' => now(),
            ],
            [
                'name' => 'IT',
                'created_at' => now(),
            ]
            
        ]);
    }
}
