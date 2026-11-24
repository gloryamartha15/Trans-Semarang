<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComplaintStatusHistory extends Model
{
    protected $table = 'complaint_status_histories';

    protected $fillable = [
        'complaint_id',
        'user_id',
        'old_status',
        'new_status',
        'notes',
    ];

    public function complaint(): BelongsTo
    {
        return $this->belongsTo(Complaints::class, 'complaint_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
