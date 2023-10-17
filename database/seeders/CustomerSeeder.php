<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Location;
use App\Models\Organization;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        Customer::factory()
            ->count(3)
            ->forOrganization([
                'name' => 'Org A'
            ])
            ->forLocation([
                'name' => 'Jakarta'
            ])
            ->create();
    }
}
