<?php

namespace App\Http\Controllers;

use App\Charts\ScoreChart;
use App\Contest;
use App\Quest;
use App\User;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Debug\Dumper;

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
        $contest = $this->contest;
        $quests = $this->contest->quests->groupBy('category');
        return view('quest', compact('quests', 'contest'));
    }

    public function scoreboard()
    {
        if (!$this->isJoinContest()) {
            return redirect()->route('join.contest.page');
        }
        $users = $this->contest->users()->with('records.quest')->wherePivot('is_hidden', false)->get();
        $scores = [];
        $quests = $this->contest->quests->pluck('id');
        if ($users->count() === 0) {
            $chart = null;
        } else {
            $colorHash = new \Shahonseven\ColorHash();
            $chart = new ScoreChart;
            foreach ($users as $user) {
                /** @var Collection $records */
                $records = $user->records()->where('is_correct', '=', true)->whereIn('quest_id', $quests)->get()->groupBy('quest_id');
                $tmp = [0 => ['x' => 0, 'y' => 0]];
                $i = 1;
                foreach ($records as $record_list) {
                    $record = $record_list->first();
                    array_push($tmp, ['x' => $i, 'y' => $tmp[$i - 1]['y'] + $record->point]);
                    $i += 1;
                }
                $scores = array_merge($scores, [$user->name => end($tmp)['y']]);
                $chart->labels(['A', 'B'])->dataset($user->name, 'scatter', $tmp)->options([
                    'fill'        => false,
                    'lineTension' => 0,
                    'showLine'    => true,
                    'borderColor' => $colorHash->hex($user->name),
                ]);
            }
        }
        $scores = collect($scores)->sort()->reverse();

        return view('scoreboard', compact('users', 'scores', 'chart'));
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
            $user->contests()->attach($this->contest, ['is_admin' => false, 'is_hidden' => false]);
            return redirect()->route('challenge')->with('success', '成功參加競賽！');
        }
    }

    private function isJoinContest()
    {
        return auth()->check() && auth()->user()->contests()->pluck('id')->contains($this->contest->id);
    }


}
