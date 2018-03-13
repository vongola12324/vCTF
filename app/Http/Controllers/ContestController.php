<?php

namespace App\Http\Controllers;

use App\Contest;
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
        $contests = Contest::with('users')->paginate(10);
        return view('manage.contest.index', compact('contests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manage.contest.create-or-edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
        Contest::create([
            'name' => uuid_v4_base64(),
            'display_name' => $request->get('display_name'),
            'start_at' => Carbon::parse($request->get('start_at')),
            'end_at' => Carbon::parse($request->get('end_at')),
        ]);

        return redirect()->route('contest.index')->with('success', '競賽建立成功！');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contest  $contest
     * @return \Illuminate\Http\Response
     */
    public function show(Contest $contest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contest  $contest
     * @return \Illuminate\Http\Response
     */
    public function edit(Contest $contest)
    {
        return view('manage.contest.create-or-edit', compact('contest'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contest  $contest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contest $contest)
    {
        dd($request->all());
        $contest->update([
            'display_name' => $request->get('display_name'),
            'start_at' => Carbon::parse($request->get('start_at')),
            'end_at' => Carbon::parse($request->get('end_at')),
        ]);

        return redirect()->route('contest.index')->with('success', '競賽更新成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contest  $contest
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
}
