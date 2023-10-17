<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'packages';

    protected $fillable = [
        'uuid',
        'customer_name',
        'customer_code',
        'transaction_order',
        'transaction_code',
        'transaction_amount',
        'transaction_discount',
        'transaction_additional_field',
        'transaction_cash_amount',
        'transaction_cash_change',
        'payment_type_id',
        'payment_type_name',
        'origin_data_id',
        'destination_data_id',
        'custom_field',
        'customer_attribute',
        'current_location',
    ];

    protected $hidden = [
        'id',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    protected $casts = [
        'custom_field' => 'array',
        'customer_attribute' => 'array',
        'current_location' => 'array',
    ];

    public function connote_data(): HasOne
    {
        return $this->hasOne(Connote::class, 'package_id');
    }

    public function origin_data(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'origin_data_id');
    }

    public function destination_data(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'destination_data_id');
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(PaymentType::class, 'payment_type_id');
    }
}
