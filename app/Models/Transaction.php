<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'type', 'wallet', 'direction',
        'amount', 'balance_after', 'reference_id', 'description', 'status',
    ];

    public function user() { return $this->belongsTo(User::class); }

    public function deposit()
    {
        return $this->belongsTo(Deposit::class, 'reference_id');
    }
}
