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
        if ($current === null) {
            session(['current_contest' => null]);
        } else {
            session(['current_contest' => $current->data]);
        }
        return $next($request);
    }
}
