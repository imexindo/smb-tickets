<?php

namespace Database\Seeders;

use App\Models\PK;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PK::insert([
            [
                'u_sol_pk' => '1',
                'pk' => '0.50',
                'nick_pk' => 'KF20',
                'desc' => '1/2 PK',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'u_sol_pk' => '2',
                'pk' => '0.75',
                'nick_pk' => 'KF23',
                'desc' => '3/4 PK',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'u_sol_pk' => '3',
                'pk' => '1.00',
                'nick_pk' => 'KF26',
                'desc' => '1 PK',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'u_sol_pk' => '6',
                'pk' => '1.50',
                'nick_pk' => 'KF34',
                'desc' => '1.5 PK',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'u_sol_pk' => '9',
                'pk' => '2.00',
                'nick_pk' => 'KF50',
                'desc' => '2 PK',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'u_sol_pk' => '10',
                'pk' => '3.00',
                'nick_pk' => 'KF70',
                'desc' => '3 PK',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'u_sol_pk' => '13',
                'pk' => '5.00',
                'nick_pk' => 'KF120',
                'desc' => '5 PK',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'u_sol_pk' => '14',
                'pk' => '4.00',
                'nick_pk' => 'KF100',
                'desc' => '4 PK',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'u_sol_pk' => '18',
                'pk' => '3.50',
                'nick_pk' => 'KF90',
                'desc' => '3.5 PK',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'u_sol_pk' => '19',
                'pk' => '8.00',
                'nick_pk' => 'DB80',
                'desc' => '8 PK',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'u_sol_pk' => '20',
                'pk' => '15.00',
                'nick_pk' => 'DB150',
                'desc' => '15 PK',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'u_sol_pk' => '21',
                'pk' => '20.00',
                'nick_pk' => 'DB200',
                'desc' => '20 PK',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'u_sol_pk' => '22',
                'pk' => '6.00',
                'nick_pk' => 'DB60',
                'desc' => '6 PK',
                'status' => 1,
                'created_at' => now(),
            ],
            [
                'u_sol_pk' => '23',
                'pk' => '10.00',
                'nick_pk' => 'DB100',
                'desc' => '10 PK',
                'status' => 1,
                'created_at' => now(),
            ],
            
        ]);
    }
}
