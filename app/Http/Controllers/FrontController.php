<?php

namespace App\Http\Controllers;

use App\Contest;
use App\User;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    /** @var Contest $contest */
    protected $contest;

    public function __construct()
    {
        if (session('current_contest', null) !== null) {
            $contest = Contest::whereId(intval(session('current_contest')))->first();
        } else {
            $contest = null;
        }
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
        return view('quest', compact('quests'));
    }

    public function scoreboard()
    {
        $users = $this->contest->users()->with('records')->get();
        return view('scoreboard', compact('users'));
    }
}
