<?php

namespace Database\Seeders;

use App\Models\StatusSO;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSOSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StatusSO::insert([
            [
                'name' => 'PASANG BARU',
                'created_at' => now(),
            ],
            [
                'name' => 'PERPANJANGAN SEWA',
                'created_at' => now(),
            ],
            [
                'name' => 'PUTUS SEWA',
                'created_at' => now(),
            ],
            [
                'name' => 'GESER/BONGKAR PASANG',
                'created_at' => now(),
            ],
            [
                'name' => 'PENAMBAHAN AC',
                'created_at' => now(),
            ],
            [
                'name' => 'RELOKASI',
                'created_at' => now(),
            ],
            [
                'name' => 'TAKE OVER / LAIN-LAIN',
                'created_at' => now(),
            ],
            [
                'name' => 'TAGANTI UNIT / PK',
                'created_at' => now(),
            ],
            [
                'name' => 'PPS',
                'created_at' => now(),
            ],
            
        ]);
    }
}
