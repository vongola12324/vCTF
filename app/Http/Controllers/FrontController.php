<?php

namespace App\Http\Controllers;

use App\Contest;
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
        $teams = $this->contest->users();
        return view('team', compact('teams'));
    }

    public function quest()
    {
        $quests = $this->contest->quests;
        $hasJoin = $this->hasJoin;
        return view('quest', compact('quests', 'hasJoin'));
    }

    public function scoreboard()
    {
        $users = $this->contest->users()->with('records')->get();
        return view('scoreboard', compact('users'));
    }
}
