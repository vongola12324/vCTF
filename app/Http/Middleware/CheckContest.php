<?php

namespace App\Http\Middleware;

use App\Contest;
use Closure;

class CheckContest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $contest = $request->route('contest');
        $quest = $request->route('quest');
        if ($quest !== null) {
            if (!$contest->quests()->pluck('id')->contains($quest->id)) {
                return redirect()->route('contest.index')->with('warning', '查無此題目。');
            }
        }
        return $next($request);
    }
}
