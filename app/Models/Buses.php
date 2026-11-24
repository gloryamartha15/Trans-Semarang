<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buses extends Model
{
    protected $table = 'buses';

    protected $fillable = [
        'route_id',
        'police_number',
        'qr_code',
        'qr_options',
        'bus_number',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'qr_options' => 'array',
            'is_active' => 'boolean',
        ];
    }

    // Relasi Bus ke Rute
    public function route(): BelongsTo
    {
        return $this->belongsTo(Routes::class, 'route_id');
    }

    // Relasi Bus ke Aduan
    public function complaints(): HasMany
    {
        return $this->hasMany(Complaints::class, 'bus_id');
    }
}