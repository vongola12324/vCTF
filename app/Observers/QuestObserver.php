<?php

namespace App\Observers;


use App\Quest;

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