<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RouteStop extends Model
{
    protected $table = 'route_stop';

    protected $fillable = [
        'route_id',
        'stop_id',
        'stop_order',
    ];

    // Relasi ke data rute
    public function route(): BelongsTo
    {
        return $this->belongsTo(Routes::class, 'route_id');
    }

    // Relasi ke data halte
    public function stop(): BelongsTo
    {
        return $this->belongsTo(Stops::class, 'stop_id');
    }
}
