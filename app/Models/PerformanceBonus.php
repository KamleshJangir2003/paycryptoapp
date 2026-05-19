<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerformanceBonus extends Model
{
    protected $fillable = [
        'user_id', 'bonus_date', 'daily_volume',
        'target_amount', 'bonus_amount', 'target_achieved', 'status',
    ];

    protected $casts = ['bonus_date' => 'date', 'target_achieved' => 'boolean'];

    public function user() { return $this->belongsTo(User::class); }
}
