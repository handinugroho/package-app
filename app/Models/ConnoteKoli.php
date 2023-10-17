<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConnoteKoli extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'connote_kolis';

    protected $fillable = [
        'uuid',
        'connote_id',
        'code',
        'description',
        'awb_url',
        'formula_id',
        'length',
        'chargeable_weight',
        'width',
        'height',
        'volume',
        'weight',
        'surcharge',
        'custom_field',
    ];

    protected $hidden = [
        'id',
        'deleted_at',
    ];

    protected $casts = [
        'surcharge' => 'array',
        'custom_field' => 'array',
    ];

    public function connote()
    {
        return $this->belongsTo(Connote::class, 'connote_id');
    }
}
