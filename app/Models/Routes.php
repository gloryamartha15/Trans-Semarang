<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Routes extends Model
{
    protected $table = 'routes';

    protected $fillable = [
        'route_code',
        'route_name',
        'start_point',
        'end_point',
        'is_active',
    ];

    // Satu rute memiliki banyak bus
    public function buses(): HasMany
    {
        return $this->hasMany(Buses::class, 'route_id');
    }

    // Satu rute melewati banyak halte
    public function stops(): BelongsToMany
    {
        return $this->belongsToMany(
            Stops::class,
            'route_stop',
            'route_id',
            'stop_id'
        )
            ->withPivot('stop_order')
            ->orderByPivot('stop_order');
    }

    // Satu rute memiliki banyak data urutan halte
    public function routeStops(): HasMany
    {
        return $this->hasMany(RouteStop::class, 'route_id')
            ->orderBy('stop_order');
    }
}
