<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_status')->insert([
            ['name' => 'Open', 'created_at' => now()],
            ['name' => 'Process', 'created_at' => now()],
            ['name' => 'Pending', 'created_at' => now()],
            ['name' => 'Success', 'created_at' => now()],
        ]);
    }
}
