<?php

namespace Database\Seeders;

use App\Models\ConnoteState;
use Illuminate\Database\Seeder;

class ConnoteStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        ConnoteState::insert([
            [
                'state' => 'PENDING',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'state' => 'PAID',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
