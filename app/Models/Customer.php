<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'customers';

    protected $fillable = [
        'organization_id',
        'location_id',
        'name',
        'address',
        'address_detail',
        'email',
        'phone_number',
        'zip_code',
        'zone_code',
    ];

    protected $hidden = [
        'id',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function package_origin_data(): HasMany
    {
        return $this->hasMany(Package::class, 'origin_data_id');
    }

    public function package_destination_data(): HasMany
    {
        return $this->hasMany(Package::class, 'destination_data_id');
    }
}
