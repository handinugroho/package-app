<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Location;
use App\Models\Organization;
use App\Models\Package;
use App\Models\PaymentType;
use Database\Seeders\ConnoteStateSeeder;
use Database\Seeders\PackageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PackageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_packages_empty()
    {
        $response = $this->get('/api/package');

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_packages()
    {
        // default seed
        $this->seed();

        // call package seeder
        $this->seed(PackageSeeder::class);

        $package = Package::first();

        $response = $this->get('/api/package');

        $response
            ->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('success')
                    ->has('message')
                    ->has('data', 2)
            );
    }

    public function test_get_package_by_id()
    {
        $this->seed();

        // get first package in DB
        $package = Package::first();

        $response = $this->get('/api/package/' . $package->uuid);

        $response->assertStatus(200)
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('success')
                    ->has('message')
                    ->has(
                        'data',
                        fn ($json) =>
                        $json->where('uuid', $package->uuid)
                            ->etc()
                    )
            );;
    }

    public function test_get_not_found_package_by_id()
    {
        $response = $this->get('/api/package/' . 1);

        $response
            ->assertStatus(404);
    }

    public function test_create_package()
    {
        $organization =  Organization::factory()->state(['name' => 'Org A'])
            ->create();

        $location = Location::factory()->create();

        $payment_type = PaymentType::factory()->create();

        $this->seed([
            ConnoteStateSeeder::class,
        ]);


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

        $data = [
            "customer_name" => "PT. AMARA PRIMATIGA",
            "customer_code" => "1678593",
            "transaction_order" => 121,
            "transaction_code" => "CGKFT20200715121",
            "transaction_amount" => 70700,
            "transaction_discount" => 0,
            "transaction_additional_field" => "",
            "transaction_cash_amount" => 0,
            "transaction_cash_change" => 0,
            "additional_field" => "",
            "organization_uuid" => $organization->uuid,
            "payment_type_uuid" => $payment_type->uuid,
            "origin_data_uuid" => $origin_data->uuid,
            "destination_data_uuid" => $dest_data->uuid,
            "custom_field" => [
                "catatan_tambahan" => "JANGAN DI BANTING / DI TINDIH"
            ],
            "customer_attribute" => [
                "TOP" => "14 Hari",
                "Nama_Sales" => "Radit Fitrawikarsa",
                "Jenis_Pelanggan" => "B2B"
            ],
            "current_location" => [
                "code" => "JKTS01",
                "name" => "Hub Jakarta Selatan",
                "type" => "Agent"
            ],
            "connote_data" => [
                "number" => 1,
                "connote_state" => "PAID",
                "service" => "ECO",
                "service_price" => 70700,
                "amount" => 70700,
                "booking_code" => "",
                "zone_code_from" => "CGKFT",
                "zone_code_to" => "SMG",
                "surcharge_amount" => null,
                "actual_weight" => 20,
                "volume_weight" => 0,
                "chargeable_weight" => 20,
                "total_package" => 3,
                "sla_day" => 4,
                "location_name" => "Hub Jakarta Selatan",
                "location_type" => "HUB",
                "source_tariff_type" => "tariff_customers",
                "source_tariff_id" => 1576868,
                "pod" => null,
                "history" => []
            ],
            "koli_data" => [
                [
                    "koli_length" => 0,
                    "koli_chargeable_weight" => 9,
                    "koli_width" => 0,
                    "koli_surcharge" => [],
                    "koli_height" => 0,
                    "koli_description" => "V WARP",
                    "koli_formula_id" => null,
                    "koli_volume" => 0,
                    "koli_weight" => 9,
                    "koli_custom_field" => [
                        "awb_sicepat" => null,
                        "harga_barang" => null
                    ]
                ],
                [
                    "koli_length" => 0,
                    "koli_chargeable_weight" => 9,
                    "koli_width" => 0,
                    "koli_surcharge" => [],
                    "koli_height" => 0,
                    "koli_description" => "V WARP",
                    "koli_formula_id" => null,
                    "koli_volume" => 0,
                    "koli_weight" => 9,
                    "koli_custom_field" => [
                        "awb_sicepat" => null,
                        "harga_barang" => null
                    ]
                ],
                [
                    "koli_length" => 0,
                    "koli_chargeable_weight" => 2,
                    "koli_width" => 0,
                    "koli_surcharge" => [],
                    "koli_height" => 0,
                    "koli_description" => "LID HOT CUP",
                    "koli_formula_id" => null,
                    "koli_volume" => 0,
                    "koli_weight" => 2,
                    "koli_custom_field" => [
                        "awb_sicepat" => null,
                        "harga_barang" => null
                    ]
                ]
            ]
        ];

        $response = $this->postJson('/api/package', $data);

        // get data from DB
        $package_from_db = Package::with([
            'origin_data',
            'destination_data',
            'connote_data',
            'connote_data.koli_data',
        ])
            ->first();

        $response
            ->assertStatus(200)
            ->assertJsonPath('data.uuid', $package_from_db->uuid);
    }

    public function test_update_missing_package()
    {
        $response = $this->putJson('/api/package/' . 1);

        $response
            ->assertStatus(404);
    }

    public function test_update_package()
    {
        $this->seed();
        // get first package in DB
        $package = $package = Package::with([
            'organization',
            'payment_type',
            'origin_data',
            'destination_data',
            'connote_data',
            'connote_data.koli_data',
        ])
            ->first();

        $response = $this->putJson(
            '/api/package/' . $package->uuid,
            [
                "customer_name" => "PT. AMARA PRIMATIGA",
                "customer_code" => "1678593",
                "transaction_order" => 121,
                "transaction_code" => "CGKFT20200715121",
                "transaction_amount" => 70700,
                "transaction_discount" => 0,
                "transaction_additional_field" => "",
                "transaction_cash_amount" => 0,
                "transaction_cash_change" => 0,
                "additional_field" => "",
                "organization_uuid" => $package->organization->uuid,
                "payment_type_uuid" => $package->payment_type->uuid,
                "origin_data_uuid" => $package->origin_data->uuid,
                "destination_data_uuid" => $package->destination_data->uuid,
                "custom_field" => [
                    "catatan_tambahan" => "JANGAN DI BANTING / DI TINDIH"
                ],
                "customer_attribute" => [
                    "TOP" => "14 Hari",
                    "Nama_Sales" => "Radit Fitrawikarsa",
                    "Jenis_Pelanggan" => "B2B"
                ],
                "current_location" => [
                    "code" => "JKTS01",
                    "name" => "Hub Jakarta Selatan",
                    "type" => "Agent"
                ],
                "connote_data" => [
                    "number" => 1,
                    "connote_state" => "PAID",
                    "service" => "ECO",
                    "service_price" => 70700,
                    "amount" => 70700,
                    "booking_code" => "",
                    "zone_code_from" => "CGKFT",
                    "zone_code_to" => "SMG",
                    "surcharge_amount" => null,
                    "actual_weight" => 20,
                    "volume_weight" => 0,
                    "chargeable_weight" => 20,
                    "total_package" => 3,
                    "sla_day" => 4,
                    "location_name" => "Hub Jakarta Selatan",
                    "location_type" => "HUB",
                    "source_tariff_type" => "tariff_customers",
                    "source_tariff_id" => 1576868,
                    "pod" => null,
                    "history" => []
                ],
                "koli_data" => [
                    [
                        "koli_length" => 0,
                        "koli_chargeable_weight" => 9,
                        "koli_width" => 0,
                        "koli_surcharge" => [],
                        "koli_height" => 0,
                        "koli_description" => "V WARP",
                        "koli_formula_id" => null,
                        "koli_volume" => 0,
                        "koli_weight" => 9,
                        "koli_custom_field" => [
                            "awb_sicepat" => null,
                            "harga_barang" => null
                        ]
                    ]
                ]
            ]
        );

        $response
            ->assertStatus(200);

        $package->refresh();

        $this->assertDatabaseHas('connote_kolis', [
            'uuid' => $package->connote_data->koli_data[0]->uuid,
        ]);
    }

    public function test_patch_package()
    {
        $this->seed();
        // get first package in DB
        $package = $package = Package::with([
            'organization',
            'payment_type',
            'origin_data',
            'destination_data',
            'connote_data',
            'connote_data.koli_data',
        ])
            ->first();

        $response = $this->patchJson(
            '/api/package/' . $package->uuid,
            [
                'customer_name' => 'ASD',
                "current_location" => [
                    "code" => "JKT01",
                    "name" => "Hub Jakarta Selatan",
                    "type" => "Agent Edited"
                ],
                'connote_data' => [
                    'number' => 15,
                ],
            ]
        );

        $response
            ->assertStatus(200);

        $package->refresh();

        $this->assertDatabaseHas('packages', [
            'uuid' => $package->uuid,
        ]);

        $this->assertEquals($package->connote_data->number, 15);
        $this->assertEquals($package->current_location['type'], 'Agent Edited');
    }

    public function test_delete_package()
    {
        $this->seed();

        $package = Package::with([
            'origin_data',
            'destination_data',
            'connote_data',
            'connote_data.koli_data',
        ])
            ->first();

        $response = $this->deleteJson('/api/package/' . $package->uuid);

        $response->assertStatus(200);

        $this->assertSoftDeleted('packages', [
            'uuid' => $package->uuid,
        ]);
    }

    public function test_delete_missing_package()
    {
        $this->seed();

        $package = Package::with([
            'origin_data',
            'destination_data',
            'connote_data',
            'connote_data.koli_data',
        ])
            ->first();

        // model should be not found
        $response = $this->deleteJson('/api/package/' . '1');

        $response->assertStatus(404);

        $this->assertNotSoftDeleted('packages', [
            'uuid' => $package->uuid,
        ]);
    }
}
