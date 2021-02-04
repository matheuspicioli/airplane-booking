<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Travel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'travels';
    protected $fillable = [
        'name',
        'leave',
        'arrival',
    ];

    public function aircraft(): BelongsTo
    {
        return $this->belongsTo(Aircraft::class, 'aircraft_id');
    }

    public function booking(): HasOne
    {
        return $this->hasOne(Booking::class, 'travel_id');
    }
}
