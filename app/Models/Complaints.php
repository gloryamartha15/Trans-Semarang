<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Complaints extends Model
{
    protected $table = 'complaints';

    protected $fillable = [
        'no_aduan',
        'user_id',
        'bus_id',
        'stop_id',
        'categories_id',
        'nama_pengadu',
        'judul',
        'isi_aduan',
        'dokumentasi',
        'status_aduan',
    ];

    protected static function booted(): void
    {
        static::creating(function ($complaint) {
            if (empty($complaint->no_aduan)) {
                $complaint->no_aduan = 'ADU-'
                    . now()->format('Ymd')
                    . '-'
                    . Str::upper(Str::random(5));
            }
        });
    }

    public function buses()
    {
        return $this->belongsTo(Buses::class, 'bus_id');
    }

    public function categories()
    {
        return $this->belongsTo(Categories::class, 'categories_id');
    }

    public function stops()
    {
        return $this->belongsTo(Stops::class, 'stop_id');
    }

    public function replays()
    {
        return $this->hasMany(ComplaintsReplay::class, 'complaints_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
