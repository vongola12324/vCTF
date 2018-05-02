<?php

namespace App\Http\Middleware;

use App\Setting;
use Cache;
use Closure;

class GetCurrentContest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Cache::has('current_contest')) {
            $current = Setting::whereKey('current_contest')->first();
            Cache::forever('current_contest', $current->value);
        }

        return $next($request);
    }
}
