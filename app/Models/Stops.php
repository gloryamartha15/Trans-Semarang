<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Stops extends Model
{
    protected $table = 'stops';

    protected $fillable = [
        'stops_number',
        'qr_code',
        'name_stop',
        'qr_options',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'qr_options' => 'array',
            'is_active' => 'boolean',
        ];
    }

    // Satu halte dapat memiliki banyak aduan
    public function complaints(): HasMany
    {
        return $this->hasMany(Complaints::class, 'stop_id');
    }

    // Satu halte dapat dilewati oleh banyak rute
    public function routes(): BelongsToMany
    {
        return $this->belongsToMany(
            Routes::class,
            'route_stop',
            'stop_id',
            'route_id'
        )->withPivot('stop_order')
         ->orderByPivot('stop_order');
    }
}
