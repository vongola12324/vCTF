<?php

namespace App\Http\Controllers;

use App\Contest;
use App\Quest;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class QuestController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.contest');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Contest $contest
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Contest $contest)
    {
        $quests = $contest->quests->groupBy('category');
        return view('manage.quest.index', compact('contest', 'quests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Contest $contest
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Contest $contest)
    {
        $categories = $contest->quests->keyBy('category')->keys();
        return view('manage.quest.create', compact('contest', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Contest $contest
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Contest $contest)
    {
        $this->validate($request, [
            'title'     => 'required|string',
            'category'  => 'required|string',
            'content'   => 'required|string',
            'flag_type' => 'required|integer|between:0,1',
            'flag'      => 'required|string',
            'point'     => 'required|integer|min:0',
            'seq'       => 'required|integer|min:0',
            'hidden'    => 'nullable|string',
        ]);
        $quest = Quest::create([
            'contest_id' => $contest->id,
            'category'   => $request->get('category'),
            'title'      => $request->get('title'),
            'content'    => $request->get('content'),
            'flag'       => $request->get('flag'),
            'flag_type'  => $request->get('flag_type'),
            'point'      => $request->get('point'),
            'seq'        => $request->get('seq'),
            'hidden'     => $request->has('hidden'),
        ]);
        return redirect()->route('quest.index', $contest)->with('success', '競賽題目建立成功！');
    }

    /**
     * Display the specified resource.
     *
     * @param Contest $contest
     * @param  Quest $quest
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Contest $contest, Quest $quest)
    {
        $quests = $contest->quests->groupBy('category');
        $targetQuest = $quest;
        return view('manage.quest.index', compact('contest', 'quests', 'targetQuest'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Contest $contest
     * @param  \App\Quest $quest
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Contest $contest, Quest $quest)
    {
        $categories = $contest->quests->keyBy('category')->keys();
        return view('manage.quest.edit', compact('contest', 'quest', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Contest $contest
     * @param  \App\Quest $quest
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contest $contest, Quest $quest)
    {
        $this->validate($request, [
            'title'     => 'required|string',
            'category'  => 'required|string',
            'content'   => 'required|string',
            'flag_type' => 'required|integer|between:0,1',
            'flag'      => 'required|string',
            'point'     => 'required|integer|min:0',
            'seq'       => 'required|integer|min:0',
            'hidden'    => 'nullable|string',
        ]);
        $quest->update([
            'category'  => $request->get('category'),
            'title'     => $request->get('title'),
            'content'   => $request->get('content'),
            'flag'      => $request->get('flag'),
            'flag_type' => $request->get('flag_type'),
            'point'     => $request->get('point'),
            'seq'       => $request->get('seq'),
            'hidden'    => $request->has('hidden'),
        ]);
        return redirect()->route('quest.index', $contest)->with('success', '競賽題目更新成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Contest $contest
     * @param  \App\Quest $quest
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contest $contest, Quest $quest)
    {
        try {
            $quest->delete();
        } catch (\Exception $e) {
            return redirect()->route('quest.index', $contest)->with('warning', '競賽題目刪除失敗！');
        }

        return redirect()->route('quest.index', $contest)->with('success', '競賽題目刪除成功！');

    }

    /**
     * @param Contest $contest
     * @param Quest $quest
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showUploadPage(Contest $contest, Quest $quest)
    {
        return view('manage.quest.upload', compact('contest', 'quest'));
    }

    public function uploadFile(Request $request, Contest $contest, Quest $quest)
    {
        $this->validate($request, [
            'file' => 'required|file'
        ]);
        try {
            $quest->attach($request->file('file'));
        } catch (\Exception $e) {
            \Log::debug($e);
            return redirect()->route('quest.upload.page', [$contest, $quest])->with('warning', '檔案上傳失敗。');
        }
        return redirect()->route('quest.upload.page', [$contest, $quest])->with('success', '檔案上傳成功。');
    }

    public function deleteFile(Request $request, Contest $contest, Quest $quest)
    {
        $this->validate($request, [
            'key' => 'required|string'
        ]);
        $attachment = $quest->attachment($request->get('key'));
        if ($attachment === null) {
            return redirect()->route('quest.upload.page', [$contest, $quest])->with('warning', '檔案刪除失敗，查無此檔案。');
        }
        try {
            $attachment->delete();
        } catch (\Exception $e) {
            \Log::debug($e);
            return redirect()->route('quest.upload.page', [$contest, $quest])->with('warning', '檔案刪除失敗。');
        }
        return redirect()->route('quest.upload.page', [$contest, $quest])->with('success', '檔案刪除成功。');
    }
}
