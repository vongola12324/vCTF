<?php

namespace App\Services;

use App\Quest;
use App\Record;
use Yish\Generators\Foundation\Service\Service;

class QuestService extends Service
{
    protected $repository;
    protected $firstModifier;

    public function __construct()
    {
        $this->firstModifier = floatval(env('QUEST_FIRST_MODIFIER', 1.2));
    }

    public function judge(Quest $quest, string $flag, int $user_id)
    {
        // 檢查Flag是否正確
        $correct = false;
        if ($quest->flag_type === FLAG_REGEX) {
            $correct = preg_match(sprintf("/^%s$/", $quest->flag), $flag) === 1;
        } else {
            $correct = $flag === $quest->flag;
        }

        // 確認有沒有Unlock Hint
        $point = $quest->point;
        foreach ($quest->hints as $hint) {
            if ($hint->users->count() > 0 && $hint->users()->pluck('id')->contains($user_id)) {
                $point -= $hint->point;
            }
        }
        // 點數防爆(?
        if ($point < 0) {
            $point = 0;
        }
        return [
            'is_correct' => $correct,
            'point'      => $correct ? $point : 0,
        ];
    }

    public function checkFirst(Quest $quest, Record $record)
    {
        $first = Record::whereQuestId($quest->id)->where('is_correct', '=', true)->orderBy('created_at')->first();
        if ($first !== null && $first->id === $record->id) {
            $record->update([
                'is_first' => true,
                'point'    => $record->point * $this->firstModifier,
            ]);
        }
    }
}
