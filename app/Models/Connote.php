<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Connote extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'connotes';

    protected $fillable = [
        'uuid',
        'number',
        'service',
        'service_price',
        'amount',
        'code',
        'booking_code',
        'connote_state_id',
        'zone_code_from',
        'zone_code_to',
        'surcharge_amount',
        'package_id',
        'actual_weight',
        'volume_weight',
        'chargeable_weight',
        'organization_id',
        'total_package',
        'sla_day',
        'location_name',
        'pod',
        'history',
    ];

    protected $hidden = [
        'id',
        'package_id',
        'connote_state_id',
        'organization_id',
    ];

    protected $casts = [
        'pod' => 'array',
        'history' => 'array',
    ];

    public function state(): BelongsTo
    {
        return $this->belongsTo(ConnoteState::class, 'connote_state_id');
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function koli_data(): HasMany
    {
        return $this->hasMany(ConnoteKoli::class, 'connote_id');
    }
}
