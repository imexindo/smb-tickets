<?php

namespace Database\Seeders;

use App\Models\StatusTrx;
use App\Models\Trxs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusTrxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        StatusTrx::insert([
            [
                'name' => 'DITERIMA & DIPROSES (ACC)',
                'status_nick' => 'ON PROCESS (ACC)',
                'created_at' => now(),
            ],
            [
                'name' => 'MINTA REVISI KE OPR',
                'status_nick' => 'REQ-REV (ACC->OPR)',
                'created_at' => now(),
            ],
            [
                'name' => 'MINTA REVISI KE SUBCON (ACC)',
                'status_nick' => 'REQ-REV TO SC',
                'created_at' => now(),
            ],
            [
                'name' => 'FINAL ACC',
                'status_nick' => 'FINAL (ACC)',
                'created_at' => now(),
            ],
            [
                'name' => 'DIBAYAR ACC (COMPLETED)',
                'status_nick' => 'PAYMENT DONE (ACC)',
                'created_at' => now(),
            ],
            [
                'name' => 'KWITANSI BARU MASUK',
                'status_nick' => 'NEW SUBMISSION',
                'created_at' => now(),
            ],
            [
                'name' => 'DITERIMA & DIPROSES (OPR)',
                'status_nick' => 'ON PROCESS (OPR)',
                'created_at' => now(),
            ],
            [   
                'name' => 'MINTA APPROVAL KE SPV',
                'status_nick' => 'REQ APP TO SPV (OPR)',
                'created_at' => now(),
            ],
            [
                'name' => 'PROSES FINAL (OPR)',
                'status_nick' => 'FINAL PROCESS (OPR)',
                'created_at' => now(),
            ],
            [
                'name' => 'TERIMA BERKAS FINAL (OPR)',
                'status_nick' => 'FINAL COMPLETED (OPR)',
                'created_at' => now(),
            ],
            [
                'name' => 'DITERIMA UNTUK REVISI (OPR)',
                'status_nick' => 'REC & REV (OPR)',
                'created_at' => now(),
            ],
            [
                'name' => 'MINTA REVISI KE SUBCON',
                'status_nick' => 'REQ-REV TO SC (OPR)',
                'created_at' => now(),
            ],
            [
                'name' => 'OK & DIKIRIM KE ACC',
                'status_nick' => 'OK & SENT TO ACC',
                'created_at' => now(),
            ],
            [       
                'name' => 'DITOLAK UNTUK PERBAIKAN',
                'status_nick' => 'REQ-REV BY ADMIN',
                'created_at' => now(),
            ],
            [
                'name' => 'DITOLAK OLEH OPR (REJECTED)',
                'status_nick' => 'REJECTED (OPR)',
                'created_at' => now(),
            ],
        ]);
    }
}
