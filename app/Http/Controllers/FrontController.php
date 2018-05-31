<?php

namespace App\Http\Controllers;

use App\Contest;
use App\Quest;
use App\User;
use Cache;
use Illuminate\Http\Request;
use Lavary\Menu\Collection;

class FrontController extends Controller
{
    /** @var Contest $contest */
    protected $contest;

    public function __construct()
    {
        $this->contest = Contest::whereName(Cache::get('current_contest'))->first();
    }

    public function index()
    {
        $contest = $this->contest;
        return view('index', compact('contest'));
    }

    public function team()
    {
        if (!$this->isJoinContest()) {
            return redirect()->route('join.contest.page');
        }
        $teams = $this->contest->users;
        return view('team', compact('teams'));
    }

    public function quest()
    {
        if (!$this->isJoinContest()) {
            return redirect()->route('join.contest.page');
        }
        $quests = $this->contest->quests->groupBy('category');
        return view('quest', compact('quests'));
    }

    public function scoreboard()
    {
        if (!$this->isJoinContest()) {
            return redirect()->route('join.contest.page');
        }
        $users = $this->contest->users()->with('records.quest')->get();
        $scores = [];
        foreach ($users as $user) {
            $records = $user->records->filter(function($value, $key){
                return $value->is_correct;
            })->groupBy('quest_id');
            $s = $records->sum(function ($record) {
                $point = $record[0]->quest->point;
                return $record[0]->is_correct ? ($record[0]->is_first ? $point * 1.1 : $point) : 0;
            });
            $scores = array_merge($scores, [$user->name => $s]);
        }
        $scores = collect($scores)->sort()->reverse();
        return view('scoreboard', compact('users', 'scores'));
    }

    public function showJoinContestPage()
    {
        return view('join_contest', ['contest' => $this->contest]);
    }

    public function joinContest()
    {
        if ($this->isJoinContest()) {
            return redirect()->route('challenge')->with('success', '已經參加這場競賽了！');
        } else {
            /** @var User $user */
            $user = auth()->user();
            $user->contests()->attach($this->contest);
            return redirect()->route('challenge')->with('success', '成功參加競賽！');
        }
    }

    private function isJoinContest()
    {
        return auth()->check() && auth()->user()->contests()->pluck('id')->contains($this->contest->id);
    }


}
