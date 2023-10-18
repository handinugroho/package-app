<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatchPackageRequest;
use App\Http\Requests\StorePackageRequest;
use App\Http\Requests\UpdatePackageRequest;
use App\Models\Connote;
use App\Models\ConnoteKoli;
use App\Models\ConnoteState;
use App\Models\Customer;
use App\Models\Organization;
use App\Models\Package;
use App\Models\PaymentType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Package::all();

        return response()->json([
            'success' => true,
            'message' => '',
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePackageRequest $request)
    {
        //
        $validated = $request->safe()->all();

        DB::beginTransaction();
        try {
            $errors = [];

            $payment_type = PaymentType::where('uuid', $validated['payment_type_uuid'])->first();
            if (empty($payment_type)) {
                $errors['payment_type_uuid'] = [
                    'Payment type not found'
                ];
            }

            $origin_data = Customer::where('uuid', $validated['origin_data_uuid'])->first();
            if (empty($origin_data)) {
                $errors['origin_data_uuid'] = [
                    'Origin data not found'
                ];
            }

            $destination_data = Customer::where('uuid', $validated['destination_data_uuid'])->first();
            if (empty($destination_data)) {
                $errors['destination_data_uuid'] = [
                    'Destination data not found'
                ];
            }



            $connote_state = ConnoteState::where('state', $validated['connote_data']['connote_state'])
                ->first();
            if (empty($connote_state)) {
                $errors['connote_state'] = [
                    'Connote state not found'
                ];
            }

            $organization = Organization::where('uuid', $validated['organization_uuid'])
                ->first();
            if (empty($organization)) {
                $errors['organization_uuid'] = [
                    'Organization not found'
                ];
            }

            if (count($errors) > 0) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => "The given data was invalid.",
                    'errors' => $errors,
                ], 422);
            }

            $transaction_code = $validated['connote_data']['zone_code_from'] . Str::random(11);

            $data_package = [
                "uuid" => Str::orderedUuid(),
                'organization_id' =>  $organization->id,
                "customer_name" => $validated['customer_name'],
                "customer_code" => $validated['customer_code'],
                "transaction_order" => $validated['transaction_order'],
                "transaction_code" => $transaction_code,
                "transaction_amount" => $validated['transaction_amount'],
                "transaction_discount" => $validated['transaction_discount'],
                "transaction_additional_field" => $validated['transaction_additional_field'] ?? "",
                "transaction_cash_amount" => $validated['transaction_cash_amount'],
                "transaction_cash_change" => $validated['transaction_cash_change'],
                "custom_field" => $validated['custom_field'],
                "customer_attribute" => $validated['customer_attribute'],
                "current_location" => $validated['current_location'],
                'payment_type_id' => $payment_type->id,
                'payment_type_name' => $payment_type->name,
                'origin_data_id' => $origin_data->id,
                'destination_data_id' => $destination_data->id,
            ];

            $package = Package::create($data_package);


            $connote_code = 'AWB' . now()->format('Hisdmy');

            $data_connote = [
                'uuid' => Str::uuid(),
                'package_id' => $package->id,
                'number' => $validated['connote_data']['number'],
                'service' =>  $validated['connote_data']['service'],
                'service_price' =>  $validated['connote_data']['service_price'],
                'amount' =>  $validated['connote_data']['amount'],
                'code' =>  $connote_code,
                'booking_code' =>  $validated['connote_data']['booking_code'] ?? "",
                'connote_state_id' =>  $connote_state->id,
                'zone_code_from' =>  $validated['connote_data']['zone_code_from'],
                'zone_code_to' =>  $validated['connote_data']['zone_code_to'],
                'surcharge_amount' =>  $validated['connote_data']['surcharge_amount'],
                'actual_weight' =>  $validated['connote_data']['actual_weight'],
                'volume_weight' =>  $validated['connote_data']['volume_weight'],
                'chargeable_weight' =>  $validated['connote_data']['chargeable_weight'],
                'organization_id' =>  $organization->id,
                'total_package' =>  $validated['connote_data']['total_package'],
                'sla_day' =>  $validated['connote_data']['sla_day'],
                'location_name' => $validated['connote_data']['location_name'],
                'location_type' => $validated['connote_data']['location_type'],
                "source_tariff_type" => "tariff_customers",
                "source_tariff_id" => 1576868,
                'pod' => $validated['connote_data']['pod'] ?? null,
                'history' => $validated['connote_data']['pod'] ?? [],
            ];

            $connote = Connote::create($data_connote);


            $koli = $validated['koli_data'];
            foreach ($koli as $index => $koli) {
                $koli_code = $connote_code . "." . $index;

                ConnoteKoli::create([
                    'uuid' => Str::uuid(),
                    'connote_id' => $connote->id,
                    'awb_url' => "https://app.tracking/label/{$koli_code}",
                    'code' => $koli_code,
                    "length" => $koli['koli_length'],
                    "chargeable_weight" => $koli['koli_chargeable_weight'],
                    "width" => $koli['koli_width'],
                    "surcharge" => $koli['koli_surcharge'],
                    "height" => $koli['koli_height'],
                    "description" => $koli['koli_description'],
                    "koli_formula_id" => $koli['koli_formula_id'],
                    "volume" => $koli['koli_volume'],
                    "weight" => $koli['koli_weight'],
                    "custom_field" => $koli['koli_custom_field'],
                ]);
            }
            DB::commit();

            $package->load([
                'origin_data',
                'destination_data',
                'connote_data',
                'connote_data.koli_data',
            ]);

            return response()->json([
                'success' => true,
                'message' => "Data is successfully created",
                'data' => $package
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => "Internal server error",
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        //
        $package->load([
            'origin_data',
            'destination_data',
            'connote_data',
        ]);
        return response()->json([
            'success' => true,
            'message' => '',
            'data' => $package
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePackageRequest $request, Package $package)
    {
        //
        $validated = $request->safe()->all();


        DB::beginTransaction();
        try {
            $errors = [];

            $payment_type = PaymentType::where('uuid', $validated['payment_type_uuid'])->first();
            if (empty($payment_type)) {
                $errors['payment_type_uuid'] = [
                    'Payment type not found'
                ];
            }

            $origin_data = Customer::where('uuid', $validated['origin_data_uuid'])->first();
            if (empty($origin_data)) {
                $errors['origin_data_uuid'] = [
                    'Origin data not found'
                ];
            }

            $destination_data = Customer::where('uuid', $validated['destination_data_uuid'])->first();
            if (empty($destination_data)) {
                $errors['destination_data_uuid'] = [
                    'Destination data not found'
                ];
            }

            $connote_state = ConnoteState::where('state', $validated['connote_data']['connote_state'])
                ->first();
            if (empty($connote_state)) {
                $errors['connote_state'] = [
                    'Connote state not found'
                ];
            }

            $organization = Organization::where('uuid', $validated['organization_uuid'])
                ->first();
            if (empty($organization)) {
                $errors['organization_uuid'] = [
                    'Organization not found'
                ];
            }

            if (count($errors) > 0) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => "The given data was invalid.",
                    'errors' => $errors,
                ], 422);
            }

            $transaction_code = $validated['connote_data']['zone_code_from'] . Str::random(11);

            $data_package = [
                'organization_id' =>  $organization->id,
                "customer_name" => $validated['customer_name'],
                "customer_code" => $validated['customer_code'],
                "transaction_order" => $validated['transaction_order'],
                "transaction_code" => $transaction_code,
                "transaction_amount" => $validated['transaction_amount'],
                "transaction_discount" => $validated['transaction_discount'],
                "transaction_additional_field" => $validated['transaction_additional_field'] ?? "",
                "transaction_cash_amount" => $validated['transaction_cash_amount'],
                "transaction_cash_change" => $validated['transaction_cash_change'],
                "custom_field" => $validated['custom_field'],
                "customer_attribute" => $validated['customer_attribute'],
                "current_location" => $validated['current_location'],
                'payment_type_id' => $payment_type->id,
                'payment_type_name' => $payment_type->name,
                'origin_data_id' => $origin_data->id,
                'destination_data_id' => $destination_data->id,
            ];

            Package::where('id', $package->id)->update($data_package);


            $data_connote = [
                'number' => $validated['connote_data']['number'],
                'service' =>  $validated['connote_data']['service'],
                'service_price' =>  $validated['connote_data']['service_price'],
                'amount' =>  $validated['connote_data']['amount'],
                'booking_code' =>  $validated['connote_data']['booking_code'] ?? "",
                'connote_state_id' =>  $connote_state->id,
                'zone_code_from' =>  $validated['connote_data']['zone_code_from'],
                'zone_code_to' =>  $validated['connote_data']['zone_code_to'],
                'surcharge_amount' =>  $validated['connote_data']['surcharge_amount'],
                'actual_weight' =>  $validated['connote_data']['actual_weight'],
                'volume_weight' =>  $validated['connote_data']['volume_weight'],
                'chargeable_weight' =>  $validated['connote_data']['chargeable_weight'],
                'organization_id' =>  $organization->id,
                'total_package' =>  $validated['connote_data']['total_package'],
                'sla_day' =>  $validated['connote_data']['sla_day'],
                'location_name' => $validated['connote_data']['location_name'],
                'location_type' => $validated['connote_data']['location_type'],
                "source_tariff_type" => "tariff_customers",
                "source_tariff_id" => 1576868,
                'pod' => $validated['connote_data']['pod'] ?? null,
                'history' => $validated['connote_data']['pod'] ?? [],
            ];

            // update connote
            Connote::where('package_id', $package->id)
                ->update($data_connote);

            $connote = $package->connote_data;

            // soft delete old kolis
            ConnoteKoli::where('connote_id', $connote->id)
                ->delete();

            $koli = $validated['koli_data'];
            foreach ($koli as $index => $koli) {

                $koli_code = $connote->code . "." . $index;

                ConnoteKoli::create([
                    'uuid' => Str::uuid(),
                    'awb_url' => "https://app.tracking/label/{$koli_code}",
                    'connote_id' => $connote->id,
                    'code' => $koli_code,
                    "length" => $koli['koli_length'],
                    "chargeable_weight" => $koli['koli_chargeable_weight'],
                    "width" => $koli['koli_width'],
                    "surcharge" => $koli['koli_surcharge'],
                    "height" => $koli['koli_height'],
                    "description" => $koli['koli_description'],
                    "formula_id" => $koli['koli_formula_id'] ?? null,
                    "volume" => $koli['koli_volume'],
                    "weight" => $koli['koli_weight'],
                    "custom_field" => $koli['koli_custom_field'],
                ]);
            }
            DB::commit();

            $package->load([
                'origin_data',
                'destination_data',
                'connote_data',
                'connote_data.koli_data',
            ]);

            return response()->json([
                'success' => true,
                'message' => "Data is succesfully updated",
                'data' => $package
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => "Internal server error",
                'errors' => $e->getMessage(),
            ], 500);
        }
    }


    public function patchUpdate(PatchPackageRequest $request, Package $package)
    {
        //
        $package->load([
            'connote_data',
        ]);
        $validated = $request->safe()->all();


        DB::beginTransaction();

        try {
            $package_validated = Arr::except($validated, ['connote_data', 'koli_data']);

            Package::where('id', $package->id)->update($package_validated);

            if (array_key_exists('connote_data', $validated)) {
                $connote_validated = $validated['connote_data'];
                Connote::where('package_id', $package->id)
                    ->update($connote_validated);
            }


            if (array_key_exists('koli_data', $validated)) {
                $koli_data_validated = $validated['koli_data'];
                dd($koli_data_validated);

                foreach ($koli_data_validated as $koli) {
                    $koli_db = ConnoteKoli::where('uuid', $koli['uuid'])
                        ->first();

                    if ($koli_db) {
                        ConnoteKoli::where('id')
                            ->update($koli);
                    }
                }
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data is successfully updated',
                'data' => []
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => "Internal server error",
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        //
        $package->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data is successfully deleted',
            'data' => []
        ]);
    }
}
