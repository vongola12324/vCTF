<?php

namespace App\Http\Controllers;

use App\Contest;
use App\Quest;
use App\Record;
use Artisan;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:judge.manage');
    }

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
        $records = Record::whereQuestId($quest->id)->with('user')->paginate();
        return view('manage.record.index', compact('contest', 'quest', 'records'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Contest $contest
     * @param Quest $quest
     * @param  \App\Record $record
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contest $contest, Quest $quest, Record $record)
    {
        try {
            $record->delete();
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', '強制撤下失敗！');
        }
        return redirect()->back()->with('success', '強制撤下成功！');
    }

    public function rejudge(Contest $contest, Quest $quest)
    {
        Artisan::call('quest:rejudge', ['quest' => $quest->id]);
        return redirect()->back()->with('success', '重審完成！');
    }
}
