<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bookings';
    protected $fillable = [
        'checked_at',
    ];

    public function travel(): BelongsTo
    {
        return $this->belongsTo(Travel::class, 'travel_id');
    }

    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class, 'booking_id');
    }
}
