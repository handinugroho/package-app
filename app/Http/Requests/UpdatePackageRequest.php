<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePackageRequest extends FormRequest
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
            'organization_uuid' => 'required|uuid',
            'customer_name' => 'required|string',
            'customer_code' => 'required|string',
            'transaction_order' => 'required|numeric|gte:0',
            'transaction_amount' => 'required|numeric|gte:0',
            'transaction_discount' => 'required|numeric|gte:0',
            'transaction_additional_field' => 'nullable|string',
            'transaction_cash_amount' => 'required|numeric|gte:0',
            'transaction_cash_change' => 'required|numeric|gte:0',
            'payment_type_uuid' => 'required|uuid',
            'origin_data_uuid' => 'required|uuid',
            'destination_data_uuid' => 'required|uuid',
            'custom_field' => 'nullable|array',
            'customer_attribute' => 'nullable|array',
            'current_location' => 'nullable|array',
            'connote_data' => 'required|array',
            'connote_data.number' => 'required|numeric',
            'connote_data.service' => 'required|string',
            'connote_data.service_price' => 'required|numeric|gte:0',
            'connote_data.amount' => 'required|numeric|gte:0',
            'connote_data.booking_code' => 'nullable|string',
            'connote_data.zone_code_from' => 'required|string',
            'connote_data.zone_code_to' => 'required|string',
            'connote_data.surcharge_amount' => 'nullable|numeric|gte:0',
            'connote_data.actual_weight' => 'required|numeric|gte:0',
            'connote_data.volume_weight' => 'required|numeric|gte:0',
            'connote_data.chargeable_weight' => 'required|numeric|gte:0',
            'connote_data.total_package' => 'required|numeric|gte:0',
            'connote_data.sla_day' => 'required|numeric|gte:0',
            'connote_data.location_name' => 'required|string',
            'connote_data.location_type' => 'required|string',
            'connote_data.source_tariff_type' => 'required|string',
            'connote_data.source_tariff_id' => 'required|numeric',
            'connote_data.pod' => 'nullable|array',
            'connote_data.history' => 'nullable|array',
            'koli_data' => 'required|array',
            'koli_data.*.koli_length' => 'required|numeric',
            'koli_data.*.koli_chargeable_weight' => 'required|numeric|gte:0',
            'koli_data.*.koli_width' => 'required|numeric|gte:0',
            'koli_data.*.koli_surcharge' => 'nullable|array|min:0',
            'koli_data.*.koli_height' => 'required|numeric|gte:0',
            'koli_data.*.koli_description' => 'nullable|string',
            'koli_data.*.koli_formula_id' => 'nullable|numeric',
            'koli_data.*.koli_volume' => 'required|numeric|gte:0',
            'koli_data.*.koli_weight' => 'required|numeric|gte:0',
            'koli_data.*.koli_custom_field' => 'required|array',
        ];
    }
}
