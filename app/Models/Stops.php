<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stops extends Model
{
    protected $table = 'stops';

    protected $fillable = [
        'stops_number',
        'qr_code',
        'name_stop',
    ];

    public function complaints()
    {
        return $this->hasMany(Complaints::class, 'stop_id');
    }
}
