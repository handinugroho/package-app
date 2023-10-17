<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'locations';

    protected $fillable = [
        'uuid',
        'name',
        'type',
    ];

    protected $hidden = [
        'id',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
