<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aircraft extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'aircrafts';
    protected $fillable = [
        'type',
        'rows',
        'row_arrangement',
        'sits_count',
    ];

    public function getRowArrangementArrayAttribute()
    {
        return explode(' ', $this->attributes['row_arrangement']);
    }

    public function travels(): HasMany
    {
        return $this->hasMany(Travel::class, 'aircraft_id');
    }
}
