<?php

namespace Database\Seeders;

use App\Models\GroupItems;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GroupItems::insert([
            [
                'itmsgrpcod' => '100',
                'name' => 'Items',
                'group' => 'Assets',
                'created_at' => now(),
            ],
            [
                'itmsgrpcod' => '101',
                'name' => 'AC Indoor',
                'group' => 'AC',
                'created_at' => now(),
            ],
            [
                'itmsgrpcod' => '102',
                'name' => 'AC Outdoor',
                'group' => 'AC',
                'created_at' => now(),
            ],
            [
                'itmsgrpcod' => '103',
                'name' => 'Sparepart (Stock)',
                'group' => 'Sparepart',
                'created_at' => now(),
            ],
            [
                'itmsgrpcod' => '104',
                'name' => 'Service (Subcon)',
                'group' => 'Service',
                'created_at' => now(),
            ],
            [
                'itmsgrpcod' => '105',
                'name' => 'Sparepart(Non Stock)',
                'group' => 'Sparepart',
                'created_at' => now(),
            ],
            [
                'itmsgrpcod' => '108',
                'name' => 'Service (Sales)',
                'group' => 'Service',
                'created_at' => now(),
            ],
            [
                'itmsgrpcod' => '109',
                'name' => 'Sewa AC (Indoor)',
                'group' => 'Sewa AC',
                'created_at' => now(),
            ],
            [
                'itmsgrpcod' => '110',
                'name' => 'Sewa AC (Outdoor)',
                'group' => 'Sewa AC',
                'created_at' => now(),
            ],
            [
                'itmsgrpcod' => '110',
                'name' => 'Beverage Cooler',
                'group' => 'Others',
                'created_at' => now(),
            ],
            [
                'itmsgrpcod' => '111',
                'name' => 'Beverage Cooler',
                'group' => 'Others',
                'created_at' => now(),
            ],
            
        ]);
    }
}
