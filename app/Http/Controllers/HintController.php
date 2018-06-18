<?php

namespace App\Http\Controllers;

use App\Contest;
use App\Hint;
use App\Quest;
use Illuminate\Http\Request;

class HintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Contest $contest
     * @param Quest $quest
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Contest $contest, Quest $quest)
    {
        $hints = $quest->hints;
        return view('manage.hint.index', compact('contest', 'quest', 'hints'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Contest $contest
     * @param Quest $quest
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Contest $contest, Quest $quest)
    {
        return view('manage.hint.create', compact('contest', 'quest'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Contest $contest
     * @param Quest $quest
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Contest $contest, Quest $quest)
    {
        $this->validate($request, [
            'content' => 'required|string',
            'point'   => 'required|integer|min:0',
        ]);
        $point = intval($request->get('point', 0));
        if ($point > $quest->point) {
            return redirect()->back()->with('warning', '提示分數不可大於題目分數。')->withInput();
        }
        Hint::create([
            'quest_id' => $quest->id,
            'content'  => $request->get('content'),
            'point'    => $point,
        ]);
        return redirect()->route('hint.index', [$contest, $quest])->with('success', '提示新增成功！');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Contest $contest
     * @param Quest $quest
     * @param  \App\Hint $hint
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Contest $contest, Quest $quest, Hint $hint)
    {
        return view('manage.hint.edit', compact('contest', 'quest', 'hint'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Contest $contest
     * @param Quest $quest
     * @param  \App\Hint $hint
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contest $contest, Quest $quest, Hint $hint)
    {
        $this->validate($request, [
            'content' => 'required|string',
            'point'   => 'required|integer|min:0',
        ]);
        $point = intval($request->get('point', 0));
        if ($point > $quest->point) {
            return redirect()->back()->with('warning', '提示分數不可大於題目分數。')->withInput();
        }
        $hint->update([
            'content'  => $request->get('content'),
            'point'    => $point,
        ]);
        return redirect()->route('hint.index', [$contest, $quest])->with('success', '提示更新成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Contest $contest
     * @param Quest $quest
     * @param  \App\Hint $hint
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contest $contest, Quest $quest, Hint $hint)
    {
        try {
            $hint->delete();
        } catch (\Exception $e) {
            return redirect()->route('hint.index', [$contest, $quest])->with('warning', '提示刪除失敗');
        }
        return redirect()->route('hint.index', [$contest, $quest])->with('success', '提示刪除成功');
    }
}
