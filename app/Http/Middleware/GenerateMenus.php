<?php

namespace App\Http\Middleware;

use App\Contest;
use Closure;
use Menu;
use App\User;
use Gravatar;

class GenerateMenus
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
        $contest = Contest::whereName(\Cache::get('current_contest'))->first();
        Menu::make('left_nav', function($menu) use($contest) {
            if(auth()->check() && auth()->user()->contests()->pluck('id')->contains($contest->id)) {
                $menu->add('參賽隊伍', ['route' => 'team']);
                $menu->add('競賽題目', ['route' => 'challenge']);
                $menu->add('記分板', ['route' => 'scoreboard']);
            }

        });
        Menu::make('right_nav', function($menu) {
            if (auth()->check()) {
                /** @var User $user */
                $user = auth()->user();
                if (\Laratrust::can('menu.view')) {
                    $adminMenu = $menu->add('管理選單', 'javascript:void(0)');
                    $adminMenu->add('隊伍管理', ['route' => 'user.index']);
                    $adminMenu->add('競賽管理', ['route' => 'contest.index']);
                    $adminMenu->add('紀錄檢視器', ['route' => 'log-viewer::dashboard', 'target' => '_blank', 'external' => true]);
                }
                $userMenu = $menu->add('<img src="'.Gravatar::src($user->email, 32).'" class="image is-32x32" style="border-radius: 50%;">', 'javascript:void(0)');
                $userMenu->add('<strong>' . $user->name . '</strong>', 'javascript:void(0)')->divide( ['class' => 'navbar-divider'] );
//                $userMenu->add('個人資料', ['route' => 'profile']);
                $userMenu->add('登出', ['route' => 'logout']);
            } else {
                $menu->add('登入', ['route' => 'login']);
            }
        });
        return $next($request);
    }
}
