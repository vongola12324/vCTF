<?php

namespace App\Http\Controllers;

use App\Contest;
use App\Quest;
use App\Record;
use App\User;
use Cache;
use Gravatar;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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


    public function getQuestData(Request $request)
    {
        // 檢查是否登入(要有csrf_token)
        if (!auth()->check()) {
            return $this->APIReturn($this->status['Error'], null, 'Not login.');
        }
        $contest = Contest::whereName(Cache::get('current_contest'))->first();
        if (!$contest->quests()->pluck('id')->contains($request->get('id'))) {
            return $this->APIReturn($this->status['Error'], null, 'No such quest exists.');
        } else {
            $quest = Quest::whereId($request->get('id'))->with('attachments')->first();
            foreach ($quest->attachments as $attachment) {
                $attachment->makeHidden([
                    'id',
                    'uuid',
                    'disk',
                    'key',
                    'filepath',
                    'preview_url',
                    'model_id',
                    'model_type',
                    'metadata',
                    'created_at',
                    'updated_at',
                ]);
            }
            $quest->makeHidden(['contest_id', 'hidden', 'created_at', 'updated_at']);

            $records = $quest->records->groupBy('user_id');
            $solved = 0;
            foreach ($records as $user => $list) {
                /** @var Collection $list */
                if ($list->contains('is_correct', true)) {
                    $solved += 1;
                }
            }
            $is_correct = false;
            $is_first = false;
            /** @var Collection $record */
            if ($records->count() > 0 && $records->has(auth()->id())) {
                $record = $records->get(auth()->id());
                if ($record->count() > 0) {
                    /** @var Record $first */
                    $first = $record->firstWhere('is_correct', '=', true);

                    if ($first !== null) {
                        $is_correct = $first->is_correct;
                        $is_first = $first->is_first;
                    }
                }
            }

            $status = [
                'solved'     => $solved,
                'total'      => $contest->users->count(),
                'is_correct' => $is_correct,
                'is_first'   => $is_first,
            ];

            return $this->APIReturn($this->status['Success'], ['quest' => $quest, 'status' => $status], null);
        }
    }

    /**
     * Need Auth.
     *
     * @param Request $request
     *
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
        $user = auth()->user();
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
        $flag = $request->get('flag');
        $correct = false;
        if ($quest->flag_type === FLAG_REGEX) {
            $correct = preg_match($quest->flag, $flag) === 1;
        } else {
            $correct = $flag === $quest->flag;
        }
        $record = Record::create([
            'quest_id'   => $quest->id,
            'user_id'    => $user->id,
            'flag'       => $flag,
            'is_correct' => $correct,
        ]);

        // 檢查首殺
        if ($correct) {
            $first = Record::whereQuestId($quest->id)->where('is_correct', '=', true)->orderBy('created_at')->first();
            if ($first->id === $record->id) {
                $record->update([
                    'is_first' => true,
                ]);
            }
        }
        $record->makeHidden('user_id');

        return $this->APIReturn($this->status['Success'], $record, null);
    }

}
