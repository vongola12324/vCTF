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
        $users = $this->contest->users()->with('records')->get();
        return view('scoreboard', compact('users'));
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


    /**
     * Need Auth.
     * @param Request $request
     * @return string
     */
    public function submitQuest(Request $request)
    {
        // 確定方式
        if (!$request->ajax()) {
            return $this->APIReturn($this->status['Error'], null, 'Unsupported.');
        }
        // 檢查是否登入(要有csrf_token)
        if (!auth()->check()) {
            return $this->APIReturn($this->status['Error'], null, 'Not login.');
        }
        // 驗證資料
        $validator = Validator::make($request->all(), [
            'quest' => 'required|integer|exists:quests,id',
            'flag'  => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->APIReturn($this->status['Error'], null, 'Invalid data.');
        }
        // 檢查是否爲目前競賽
        $quest = Quest::whereId($request->get('quest'))->first();
        if ($quest->contest->name !== session('current_quest')) {
            return $this->APIReturn($this->status['Error'], null, 'Not current contest.');
        }

        // 檢查flag
        $correct = false;
        if ($quest->t)
            $user = auth()->user();

        return $this->APIReturn($this->status['Success'], ['correct' => true, 'first' => true], null);
    }
}
