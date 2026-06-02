<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawalTransaction extends Model
{
    protected $fillable = [
        'withdrawal_id', 'amount', 'utr_number',
        'proof_screenshot', 'note', 'status', 'confirmed_at',
    ];

    protected $casts = ['confirmed_at' => 'datetime'];

    public function withdrawal()
    {
        return $this->belongsTo(Withdrawal::class);
    }
}
