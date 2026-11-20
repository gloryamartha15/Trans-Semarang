<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buses extends Model
{
    protected $table = 'buses';
    protected $fillable = ['police_number','qr_code','bus_number','is_active'];

    public function complaints() 
    {
        return $this->hasMany(Complaints::class, 'bus_id');
    }
}

