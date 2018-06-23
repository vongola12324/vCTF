<?php

namespace App\Http\Controllers;

use App\Contest;
use App\Setting;
use App\User;
use Cache;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ContestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $current = Cache::get('current_contest');
        $contests = Contest::with('users')->paginate(10);
        return view('manage.contest.index', compact('contests', 'current'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manage.contest.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'display_name' => 'required|string',
            'start_at'     => 'nullable|date',
            'end_at'       => 'nullable|date',
        ]);
        $contest = Contest::create([
            'name'         => uuid_v4_base64(),
            'display_name' => $request->get('display_name'),
            'start_at'     => Carbon::parse($request->get('start_at')),
            'end_at'       => Carbon::parse($request->get('end_at')),
        ]);
        $contest->users()->attach(auth()->id(), ['is_admin' => true, 'is_hidden' => true]);

        return redirect()->route('contest.index')->with('success', '競賽建立成功！');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contest $contest
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Contest $contest)
    {
        return view('manage.contest.edit', compact('contest'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Contest $contest
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contest $contest)
    {
        $this->validate($request, [
            'display_name' => 'required|string',
            'start_at'     => 'nullable|date',
            'end_at'       => 'nullable|date',
        ]);
        $contest->update([
            'display_name' => $request->get('display_name'),
            'start_at'     => Carbon::parse($request->get('start_at')),
            'end_at'       => Carbon::parse($request->get('end_at')),
        ]);

        return redirect()->route('contest.index')->with('success', '競賽更新成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contest $contest
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contest $contest)
    {
        try {
            $contest->delete();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return redirect()->route('contest.index')->with('warning', '競賽刪除失敗！請參考記錄檔以獲得更多訊息。');
        }
        return redirect()->route('contest.index')->with('success', '競賽刪除成功！');
    }

    public function change(Contest $contest)
    {
        $current = Setting::whereKey('current_contest')->first();
        $current->update(['data' => $contest->name]);
        Cache::forever('current_contest', $current->value);
        return redirect()->route('contest.index')->with('success', '競賽切換成功！');
    }

    public function getUsersPage(Contest $contest)
    {
        $users = $contest->users()->paginate();

        return view('manage.contest.users', compact('contest', 'users'));
    }

    public function setUserAdmin(Request $request, Contest $contest)
    {
        $this->validate($request, [
            'user_id'   => 'required|integer|exists:users,id|exists:user_contest,user_id',
        ]);

        $user = User::whereId($request->get('user_id'))->first();
        $current = $contest->users()->wherePivot('user_id', $user->id)->first()->pivot->is_admin;

        try {
            $contest->users()->updateExistingPivot($user->id, ['is_admin' => !$current]);
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', '參賽者屬性更新失敗！');
        }

        return redirect()->back()->with('success', '參賽者屬性更新成功！');
    }

    public function setUserHidden(Request $request, Contest $contest)
    {
        $this->validate($request, [
            'user_id'   => 'required|integer|exists:users,id|exists:user_contest,user_id',
        ]);

        $user = User::whereId($request->get('user_id'))->first();
        $current = $contest->users()->wherePivot('user_id', $user->id)->first()->pivot->is_hidden;

        try {
            $contest->users()->updateExistingPivot($user->id, ['is_hidden' => !$current]);
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', '參賽者屬性更新失敗！');
        }


        return redirect()->back()->with('success', '參賽者屬性更新成功！');
    }
}
