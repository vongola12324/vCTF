<?php

namespace App\Observers;


use App\Quest;
use Artisan;

class QuestObserver
{
    /**
     * @param Quest $quest
     * @throws \Exception
     */
    public function creating(Quest $quest)
    {
        $availableType = [
            FLAG_DIRECT, FLAG_REGEX
        ];

        if (!in_array($quest->flag_type, $availableType)) {
            throw new \Exception('Wrong type!');
        }
    }

    /**
     * @param Quest $quest
     */
    public function updated(Quest $quest)
    {
        $originalFlag = $quest->getOriginal('flag');
        $currentFlag = $quest->getAttribute('flag');
        if ($originalFlag !== $currentFlag) {
            Artisan::call('quest:rejudge', ['quest' => $quest->id]);
        }
    }

    /**
     * @param Quest $quest
     * @throws \Exception
     */
    public function deleting(Quest $quest)
    {
        $attachments = $quest->attachments;
        foreach ($attachments as $attachment) {
            $attachment->delete();
        }
    }
}