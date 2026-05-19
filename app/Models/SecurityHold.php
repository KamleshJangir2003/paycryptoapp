<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecurityHold extends Model
{
    protected $fillable = [
        'user_id', 'amount', 'reason', 'type',
        'status', 'reference_id', 'released_at',
    ];

    protected $casts = ['released_at' => 'datetime'];

    public function user() { return $this->belongsTo(User::class); }
}
