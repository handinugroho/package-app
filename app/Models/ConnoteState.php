<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConnoteState extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'connote_states';

    protected $fillable = [
        'state'
    ];

    protected $hidden = [
        'id',
    ];

    public function connote(): HasMany
    {
        return $this->hasMany(Connote::class, 'connote_state_id');
    }
}
