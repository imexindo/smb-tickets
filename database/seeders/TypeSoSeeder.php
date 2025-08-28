<?php

namespace Database\Seeders;

use App\Models\TypeSO;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeSO::insert([
            [
                'name' => 'SEWA',
                'created_at' => now(),
            ],
            [
                'name' => 'MATERIAL',
                'created_at' => now(),
            ],
            [
                'name' => 'LAIN-LAIN',
                'created_at' => now(),
            ],
            [
                'name' => 'PENJUALAN FA',
                'created_at' => now(),
            ],
        ]);
    }
}
