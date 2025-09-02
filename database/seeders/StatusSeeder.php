<?php

namespace Database\Seeders;

use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::insert([
            [
                'name' => 'NEW TICKET',
                'next_action' => '1,2',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'REJECTED',
                'next_action' => '0',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'APPROVED',
                'next_action' => '3,7',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'RECEIVE BY IT',
                'next_action' => '4,5',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'REQUEST AN APPROVAL',
                'next_action' => '6,7,8',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'PENDING (ON HOLD)',
                'next_action' => '6,7,8',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'REVISI',
                'next_action' => '4,5',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'CANCELED',
                'next_action' => '0',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'CLOSED',
                'next_action' => '9',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'CONFIRM',
                'next_action' => '0',
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
