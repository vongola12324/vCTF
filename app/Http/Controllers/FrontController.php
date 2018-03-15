<?php

namespace App\Http\Controllers;

use App\Contest;
use App\User;
use Illuminate\Http\Request;
use Lavary\Menu\Collection;

class FrontController extends Controller
{
    /** @var Contest $contest */
    protected $contest, $hasJoin;

    public function __construct()
    {
        $this->contest = Contest::whereName(session('current_contest', 'Public'))->first();
        $this->hasJoin = in_array(auth()->user(), Collection::unwrap($this->contest->users));
    }

    public function index()
    {
        $contest = $this->contest;
        $hasJoin = $this->hasJoin;
        return view('index', compact('contest', 'hasJoin'));
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
