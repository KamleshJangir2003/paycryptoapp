<?php

namespace App\Providers;

use App\Models\PaymentSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $view->with('usdtRate', PaymentSetting::get()->usdt_rate ?? 85.00);
        });
    }
}
