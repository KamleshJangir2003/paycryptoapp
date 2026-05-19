<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    protected $fillable = [
        'upi_id', 'upi_name', 'qr_image',
        'wallet_address', 'wallet_name', 'wallet_qr',
        'upi_active', 'wallet_active', 'deposit_note',
    ];

    protected $casts = [
        'upi_active'    => 'boolean',
        'wallet_active' => 'boolean',
    ];

    // Always get or create single row
    public static function get(): self
    {
        return self::firstOrCreate(['id' => 1]);
    }
}
