<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatchPackageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'organization_uuid' => 'nullable|uuid',
            'customer_name' => 'nullable|string',
            'customer_code' => 'nullable|string',
            'transaction_order' => 'nullable|numeric|gte:0',
            'transaction_amount' => 'nullable|numeric|gte:0',
            'transaction_discount' => 'nullable|numeric|gte:0',
            'transaction_additional_field' => 'nullable|string',
            'transaction_cash_amount' => 'nullable|numeric|gte:0',
            'transaction_cash_change' => 'nullable|numeric|gte:0',
            'payment_type_uuid' => 'nullable|uuid',
            'origin_data_uuid' => 'nullable|uuid',
            'destination_data_uuid' => 'nullable|uuid',
            'custom_field' => 'nullable|array',
            'customer_attribute' => 'nullable|array',
            'current_location' => 'nullable|array',
            'connote_data' => 'nullable|array',
            'connote_data.number' => 'nullable|numeric',
            'connote_data.service' => 'nullable|string',
            'connote_data.service_price' => 'nullable|numeric|gte:0',
            'connote_data.amount' => 'nullable|numeric|gte:0',
            'connote_data.booking_code' => 'nullable|string',
            'connote_data.zone_code_from' => 'nullable|string',
            'connote_data.zone_code_to' => 'nullable|string',
            'connote_data.surcharge_amount' => 'nullable|numeric|gte:0',
            'connote_data.actual_weight' => 'nullable|numeric|gte:0',
            'connote_data.volume_weight' => 'nullable|numeric|gte:0',
            'connote_data.chargeable_weight' => 'nullable|numeric|gte:0',
            'connote_data.total_package' => 'nullable|numeric|gte:0',
            'connote_data.sla_day' => 'nullable|numeric|gte:0',
            'connote_data.location_name' => 'nullable|string',
            'connote_data.location_type' => 'nullable|string',
            'connote_data.source_tariff_type' => 'nullable|string',
            'connote_data.source_tariff_id' => 'nullable|numeric',
            'connote_data.pod' => 'nullable|array',
            'connote_data.history' => 'nullable|array',
            'koli_data' => 'nullable|array',
            'koli_data.*.uuid' => 'required|uuid',
            'koli_data.*.koli_length' => 'nullable|numeric',
            'koli_data.*.koli_chargeable_weight' => 'nullable|numeric|gte:0',
            'koli_data.*.koli_width' => 'nullable|numeric|gte:0',
            'koli_data.*.koli_surcharge' => 'nullable|array|min:0',
            'koli_data.*.koli_height' => 'nullable|numeric|gte:0',
            'koli_data.*.koli_description' => 'nullable|string',
            'koli_data.*.koli_formula_id' => 'nullable|numeric',
            'koli_data.*.koli_volume' => 'nullable|numeric|gte:0',
            'koli_data.*.koli_weight' => 'nullable|numeric|gte:0',
            'koli_data.*.koli_custom_field' => 'nullable|array',
        ];
    }
}
