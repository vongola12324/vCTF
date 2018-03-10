<?php

namespace App\Http\Controllers;

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
        $vaildator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);
        if ($vaildator->fails()) {
            return $this->APIReturn($this->status['Error'], null, 'Invalid email.');
        }

        // 取得帳號
        $user = User::whereEmail($request->get('email'))->first();
        return $this->APIReturn($this->status['Success'], ['avatar' => Gravatar::src($user->email, 128)], null);
    }
}
