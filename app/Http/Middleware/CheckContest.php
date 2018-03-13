<?php

namespace App\Http\Middleware;

use App\Setting;
use Closure;

class CheckContest
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
        $current = Setting::whereKey('current_contest')->first();
        session(['current_contest' => $current->value]);

        return $next($request);
    }
}
