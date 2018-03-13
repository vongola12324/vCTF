<?php

namespace App\Http\Controllers;

use App\Quest;
use App\User;
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
     * @return string
     */
    public function APIReturn(int $status, $data = null, $msg = null)
    {
        return json_encode(['status' => $status, 'data' => $data, 'msg' => $msg]);
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
