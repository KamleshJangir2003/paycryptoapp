<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'mobile', 'email', 'password',
        'referral_code', 'referred_by',
        'otp', 'otp_expires_at', 'is_verified', 'is_active', 'role',
        'security_pin', 'upi_id', 'bank_account', 'bank_ifsc', 'bank_name',
    ];

    protected $hidden = ['password', 'otp', 'security_pin', 'remember_token'];

    protected $casts = [
        'is_verified' => 'boolean',
        'is_active'   => 'boolean',
        'otp_expires_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($user) {
            $user->referral_code = strtoupper(Str::random(8));
        });
        static::created(function ($user) {
            $user->wallet()->create();
        });
    }

    public function wallet() { return $this->hasOne(Wallet::class); }
    public function deposits() { return $this->hasMany(Deposit::class); }
    public function withdrawals() { return $this->hasMany(Withdrawal::class); }
    public function transactions() { return $this->hasMany(Transaction::class); }
    public function commissions() { return $this->hasMany(Commission::class); }
    public function supportTickets() { return $this->hasMany(SupportTicket::class); }
    public function referredBy() { return $this->belongsTo(User::class, 'referred_by'); }
    public function referrals() { return $this->hasMany(User::class, 'referred_by'); }
    public function performanceBonuses() { return $this->hasMany(PerformanceBonus::class); }
    public function securityHolds() { return $this->hasMany(SecurityHold::class); }

    public function isAdmin() { return $this->role === 'admin'; }
}
