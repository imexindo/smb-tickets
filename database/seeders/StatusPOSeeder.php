<?php

namespace Database\Seeders;

use App\Models\StatusPO;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusPOSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StatusPO::insert([
            [
                'type'       => 'NSC-1',
                'name'       => 'AC & SPAREPART IMPORT IMEX',
                'created_at' => now(),
            ],
            [
                'type'       => 'NSC-2',
                'name'       => 'AC & SPAREPART LOKAL IMEX',
                'created_at' => now(),
            ],
            [
                'type'       => 'NSC-3',
                'name'       => 'SPAREPART LOKAL (PETTY CASH)',
                'created_at' => now(),
            ],
            [
                'type'       => 'NSC-5',
                'name'       => 'AC & SPAREPART IMPORT IRU',
                'created_at' => now(),
            ],
            [
                'type'       => 'NSC-6',
                'name'       => 'AC & SPAREPART LOKAL IRU',
                'created_at' => now(),
            ],
            [
                'type'       => 'SC-1',
                'name'       => 'PASANG BARU',
                'created_at' => now(),
            ],
            [
                'type'       => 'SC-10',
                'name'       => 'PENAMBAHAN',
                'created_at' => now(),
            ],
            [
                'type'       => 'SC-11',
                'name'       => 'PERPANJANGAN SEWA',
                'created_at' => now(),
            ],
            [
                'type'       => 'SC-12',
                'name'       => 'RELOKASI',
                'created_at' => now(),
            ],
            [
                'type'       => 'SC-13',
                'name'       => 'GANTI UNIT',
                'created_at' => now(),
            ],
            [
                'type'       => 'SC-14',
                'name'       => 'REKONDISI',
                'created_at' => now(),
            ],
            [
                'type'       => 'SC-2',
                'name'       => 'SERVIS RUTIN',
                'created_at' => now(),
            ],
            [
                'type'       => 'SC-3',
                'name'       => 'PERBAIKAN SR',
                'created_at' => now(),
            ],
            [
                'type'       => 'SC-4',
                'name'       => 'GANTI PK',
                'created_at' => now(),
            ],
            [
                'type'       => 'SC-5',
                'name'       => 'PENCABUTAN',
                'created_at' => now(),
            ],
            [
                'type'       => 'SC-6',
                'name'       => 'PENGAMBILAN/PENGIRIMAN',
                'created_at' => now(),
            ],
            [
                'type'       => 'SC-7',
                'name'       => 'PERGESERAN UNIT',
                'created_at' => now(),
            ],
            [
                'type'       => 'SC-8',
                'name'       => 'KOMPLAIN',
                'created_at' => now(),
            ],
            [
                'type'       => 'SC-9',
                'name'       => 'LAIN-LAIN',
                'created_at' => now(),
            ],
        ]);
    }
}
