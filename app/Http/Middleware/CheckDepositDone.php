<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckDepositDone
{
    // Ye routes bina deposit ke bhi allow honge
    protected array $allowed = [
        'deposit.index',
        'deposit.create',
        'deposit.store',
        'logout',
        'settings',
        'settings.profile',
        'settings.password',
        'settings.password.page',
        'settings.pin',
        'settings.bank.page',
        'faq',
        'tutorial',
        'chat',
        'chat.send',
        'chat.poll',
        'support.index',
        'support.create',
        'support.store',
    ];

    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // Check karo kya user ka koi approved deposit hai
        $hasDeposit = $user->deposits()->where('status', 'approved')->exists();

        if (!$hasDeposit && !$this->isAllowed($request)) {
            return redirect()->route('deposit.create')
                ->with('warning', 'Please make your first deposit to unlock full access to the dashboard.');
        }

        return $next($request);
    }

    private function isAllowed(Request $request): bool
    {
        foreach ($this->allowed as $route) {
            if ($request->routeIs($route)) {
                return true;
            }
        }
        return false;
    }
}
