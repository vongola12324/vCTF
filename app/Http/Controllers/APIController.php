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


    public function getQuest(Quest $quest)
    {
        $contest = Contest::whereName(Cache::get('current_contest'))->first();
        if (!$contest->quests()->pluck('id')->contains($quest->id)) {
            return $this->APIReturn($this->status['Error'], null, 'No such quest exists.');
        } else {
            $data = Quest::whereId($quest->id)->with('attachments')->first();
            foreach ($data->attachments as $attachment) {
                $attachment->makeHidden(['id', 'uuid', 'disk', 'key', 'filepath', 'preview_url', 'model_id', 'model_type', 'metadata', 'created_at', 'updated_at']);
            }
            $data->makeHidden(['contest_id', 'hidden', 'created_at', 'updated_at']);
            return $this->APIReturn($this->status['Success'], $data, null);
        }
    }

}
