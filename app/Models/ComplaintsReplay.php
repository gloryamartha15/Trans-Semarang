<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintsReplay extends Model
{
    protected $table = 'complaints_replay';

    protected $fillable = [
        'complaints_id',
        'id_petugas',
        'tanggapan',
        'cycle_number',
    ];

    public function complaints()
    {
        return $this->belongsTo(
            Complaints::class,
            'complaints_id'
        );
    }

    public function petugas()
    {
        return $this->belongsTo(
            User::class,
            'id_petugas'
        );
    }
}
