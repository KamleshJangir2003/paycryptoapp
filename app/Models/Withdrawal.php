<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $fillable = [
        'user_id', 'amount', 'method', 'upi_id',
        'bank_account', 'bank_ifsc', 'bank_name',
        'qr_screenshot', 'utr_number', 'status', 'in_pool',
        'processed_by', 'processed_at', 'admin_note',
    ];

    protected $casts = ['processed_at' => 'datetime', 'in_pool' => 'boolean'];

    public function user() { return $this->belongsTo(User::class); }
    public function processedBy() { return $this->belongsTo(User::class, 'processed_by'); }
}
