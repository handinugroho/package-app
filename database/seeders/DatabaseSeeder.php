<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            OrganizationSeeder::class,
            LocationSeeder::class,
            PaymentTypeSeeder::class,
            CustomerSeeder::class,
            ConnoteStateSeeder::class,
            PackageSeeder::class,
        ]);
    }
}
