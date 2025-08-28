<?php

namespace Database\Seeders;

use App\Models\Customers;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customers::insert([
            [
                'groupcode' => '100',
                'name' => 'Indomaret',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'groupcode' => '101',
                'name' => 'Vendor Lokal',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'groupcode' => '102',
                'name' => 'Indogrosir',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'groupcode' => '103',
                'name' => 'Vendor Import',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'groupcode' => '104',
                'name' => 'Vendor Subkon',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'groupcode' => '105',
                'name' => 'Vendor Lain-Lain',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'groupcode' => '106',
                'name' => 'DC',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'groupcode' => '107',
                'name' => 'Alfamart',
                'status' => 0,
                'created_at' => now(),
            ],
            [
                'groupcode' => '108',
                'name' => 'Yummy Choice',
                'status' => 0,
                'created_at' => now(),
            ],
            [
                'groupcode' => '109',
                'name' => 'Mr.Bread',
                'status' => 0,
                'created_at' => now(),
            ],
            [
                'groupcode' => '110',
                'name' => 'Vendor Expedisi',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'groupcode' => '111',
                'name' => 'One Time Customer',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'groupcode' => '112',
                'name' => 'One Time Customer',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'groupcode' => '113',
                'name' => 'DC (Toko)',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'groupcode' => '114',
                'name' => 'Pabrik Roti',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'groupcode' => '115',
                'name' => 'Mainan',
                'status' => 0,
                'created_at' => now(),
            ],
        ]);
    }
}
