<?php

namespace App\Http\Middleware;

use App\Setting;
use Cache;
use Closure;
use Psr\SimpleCache\InvalidArgumentException;

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
        if (!Cache::has('current_contest')) {
            try {
                Cache::set('current_contest', Setting::whereKey('current_contest')->first()->value);
            } catch (InvalidArgumentException $e) {
                \Log::debug('InvalidArgumentException in CheckContest', [$e]);
            }
        }
        $current = Cache::get('current_contest', 'Public');

        session(['current_contest' => $current]);

        return $next($request);
    }
}
