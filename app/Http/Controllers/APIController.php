<?php

namespace App\Http\Controllers;

use App\Contest;
use App\Quest;
use App\User;
use Cache;
use Gravatar;
use Illuminate\Http\Request;
use Validator;

class APIController extends Controller
{
    protected $status = [
        'Error'   => -1,
        'Success' => 1,
    ];

    /**
     * @param int $status
     * @param mixed $data
     * @param null $msg
     *
     * @return string
     */
    private function APIReturn(int $status, $data = null, $msg = null)
    {
        return response()->json(['status' => $status, 'data' => $data, 'msg' => $msg]);
    }

    public function getAvatar(Request $request)
    {
        // 確定方式
        if (!$request->ajax()) {
            return $this->APIReturn($this->status['Error'], null, 'Unsupported.');
        }

        // 驗證資料
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);
        if ($validator->fails()) {
            return $this->APIReturn($this->status['Error'], null, 'Invalid email.');
        }

        // 取得帳號
        $user = User::whereEmail($request->get('email'))->first();
        return $this->APIReturn($this->status['Success'], ['avatar' => Gravatar::src($user->email, 128)], null);
    }


    public function getQuest(Request $request)
    {
        $contest = Contest::whereName(Cache::get('current_contest'))->first();
        if (!$contest->quests()->pluck('id')->contains($request->get('id'))) {
            return $this->APIReturn($this->status['Error'], null, 'No such quest exists.');
        } else {
            $data = Quest::whereId($request->get('id'))->with(['attachments', 'records'])->first();
            foreach ($data->attachments as $attachment) {
                $attachment->makeHidden(['id', 'uuid', 'disk', 'key', 'filepath', 'preview_url', 'model_id', 'model_type', 'metadata', 'created_at', 'updated_at']);
            }
            $data->makeHidden(['contest_id', 'hidden', 'created_at', 'updated_at']);
            return $this->APIReturn($this->status['Success'], $data, null);
        }
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
        $contest = Contest::whereName(Cache::get('current_contest'))->first();
        if ($quest->contest->name !== $contest->name) {
            return $this->APIReturn($this->status['Error'], null, 'Not current contest.');
        }

        // 檢查flag

        return $this->APIReturn($this->status['Success'], ['correct' => true, 'first' => true], null);
    }

}
