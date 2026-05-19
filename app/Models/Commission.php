<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $fillable = [
        'user_id', 'from_user_id', 'type',
        'transaction_amount', 'commission_rate', 'commission_amount',
        'reference_id', 'status',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function fromUser() { return $this->belongsTo(User::class, 'from_user_id'); }
}
