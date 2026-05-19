<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = ['user_id', 'main_balance', 'earnings_balance', 'pending_balance'];

    public function user() { return $this->belongsTo(User::class); }

    public function totalBalance()
    {
        return $this->main_balance + $this->earnings_balance;
    }
}
