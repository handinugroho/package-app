<?php

namespace Database\Seeders;

use App\Models\Connote;
use App\Models\ConnoteState;
use App\Models\Customer;
use App\Models\Location;
use App\Models\Organization;
use App\Models\Package;
use App\Models\PaymentType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $payment_type =  PaymentType::where('name', 'Invoice')->first();

        $organization = Organization::factory()->state(['name' => 'Org A'])->create();
        $location = Location::factory()->state(['name' => 'Semarang'])->create();

        $origin_data = Customer::factory()
            ->state([
                'name' => 'PT. NARA OKA PRAKARSA',
                'address' => 'JL. KH. AHMAD DAHLAN NO. 100, SEMARANG TENGAH 12420',
                'email' => "info@naraoka.co.id",
                'phone_number' => "024-1234567",
            ])
            ->for($organization)
            ->for($location)
            ->create();

        $dest_data = Customer::factory()
            ->state([
                'name' => 'PT AMARIS HOTEL SIMPANG LIMA',
                'address' => 'JL. KH. AHMAD DAHLAN NO. 01, SEMARANG TENGAH',
                'email' => "info@naraoka.co.id",
                'phone_number' => "024-8453499",
            ])
            ->for($organization)
            ->for($location)
            ->create();
        //
        $data = [
            'uuid' => Str::orderedUuid(),
            'customer_name' => "PT. AMARA PRIMATIGA",
            'customer_code' => "1678593",
            'transaction_order' => 121,
            'transaction_code' => 'CGKFT20200715121',
            'transaction_amount' => 70700,
            'transaction_discount' => 0,
            'transaction_additional_field' => '',
            'transaction_cash_amount' => 0,
            'transaction_cash_change' => 0,
            'organization_id' => $organization->id,
            'payment_type_id' => $payment_type->id,
            'payment_type_name' => $payment_type->name,
            'origin_data_id' => $origin_data->id,
            'destination_data_id' => $dest_data->id,
            'custom_field' => [
                'catatan_tambahan' => 'JANGAN DI BANTING / DI TINDIH'
            ],
            'customer_attribute' => [
                "Nama_Sales" => "Radit Fitrawikarsa",
                "TOP" => "14 Hari",
                "Jenis_Pelanggan" => "B2B"
            ],
            'current_location' => [
                "name" => "Hub Jakarta Selatan",
                "code" => "JKTS01",
                "type" => "Agent"
            ],
        ];

        $package = Package::create($data);


        $connote_state = ConnoteState::where('state', 'PAID')->first();
        $connote_data = [
            'uuid' => Str::uuid(),
            'number' => 1,
            'service' => "ECO",
            'service_price' => 70700,
            'amount' => 70700,
            'code' => "AWB00100209082020",
            'booking_code' => '',
            'connote_state_id' => $connote_state->id,
            'zone_code_from' => 'CGKFT',
            'zone_code_to' => 'SMG',
            'surcharge_amount' => null,
            'package_id' => $package->id,
            'actual_weight' => 20,
            'volume_weight' => 0,
            'chargeable_weight' => 20,
            'organization_id' => $organization->id,
            'total_package' => 3,
            'sla_day' => 4,
            'location_name' => 'Hub Jakarta Selatan',
            'location_type' => 'HUB',
            'source_tariff_type' => 'tariff_customers',
            'source_tariff_id' => 1576868,
            'pod' => null,
            'history' => [],
        ];

        Connote::create($connote_data);
    }
}
