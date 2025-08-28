<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::insert([
            [
                'u_sol_brand' => '0',
                'name' => 'NO BRAND',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'u_sol_brand' => '01',
                'name' => 'DR.KUHLER',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'u_sol_brand' => '02',
                'name' => 'CHANGHONG',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'u_sol_brand' => '03',
                'name' => 'HAIER',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'u_sol_brand' => '04',
                'name' => 'GREE',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'u_sol_brand' => '05',
                'name' => 'MITSUBISHI',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'u_sol_brand' => '06',
                'name' => 'TCL',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'u_sol_brand' => '07',
                'name' => 'PANASONIC',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'u_sol_brand' => '08',
                'name' => 'DAST',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'u_sol_brand' => '09',
                'name' => 'MIDEA',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'u_sol_brand' => '91',
                'name' => 'AUX',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'u_sol_brand' => '92',
                'name' => 'GREE KUHLER',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'u_sol_brand' => '93',
                'name' => 'AKARI',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'u_sol_brand' => '94',
                'name' => 'SANSUI L',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'u_sol_brand' => '95',
                'name' => 'SANSUI X',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'u_sol_brand' => '96',
                'name' => 'SHARP',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'u_sol_brand' => '99',
                'name' => 'MC QUAY',
                'status' => 1,
                'created_at' => now(),
            ],
        ]);
    }
}
