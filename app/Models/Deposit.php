<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $fillable = [
        'user_id', 'amount', 'utr_number', 'screenshot',
        'upi_id', 'status', 'verified_by', 'verified_at', 'admin_note',
    ];

    protected $casts = ['verified_at' => 'datetime'];

    public function user() { return $this->belongsTo(User::class); }
    public function verifiedBy() { return $this->belongsTo(User::class, 'verified_by'); }
}
