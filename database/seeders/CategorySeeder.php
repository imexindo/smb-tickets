<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categories::insert([
            [
                'name' => 'PENAMBAHAN MENU',
                'type' => 0,
            ],
            [
                'name' => 'PERUBAHAN MENU (MODIF)',
                'type' => 0,
            ],
            [
                'name' => 'PERUBAHAN DATA',
                'type' => 0,
            ],
            [
                'name' => 'USER AKSES',
                'type' => 0,
            ],
            [
                'name' => 'PRINT BARCODE SN',
                'type' => 0,
            ],
            [
                'name' => 'KOMPLAIN NETWORKING / INTERNET',
                'type' => 1,
            ],
            [
                'name' => 'KOMPLAIN PERALATAN (HARDWARE)',
                'type' => 1,
            ],
            [
                'name' => 'SERAH TERIMA PERALATAN IT',
                'type' => 1,
            ],
            [
                'name' => 'PEMBELIAN BARANG',
                'type' => 1,
            ],
            [
                'name' => 'RELOKASI PERALATAN IT',
                'type' => 1,
            ],
            [
                'name' => 'KOMPLAIN SOFTWARE',
                'type' => 1,
            ],
            [
                'name' => 'PENDAFTARAN EMAIL / USER',
                'type' => 1,
            ],
        ]);
    }
}
