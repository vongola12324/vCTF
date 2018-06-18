<?php

namespace App\Console\Commands;

use App\Quest;
use App\Record;
use App\Services\QuestService;
use Illuminate\Console\Command;

class QuestRejudge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quest:rejudge {quest : The id of quest.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rejudge all records in specify quest.';
    protected $questService;

    /**
     * Create a new command instance.
     *
     * @param QuestService $questService
     */
    public function __construct(QuestService $questService)
    {
        parent::__construct();
        $this->questService = $questService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $quest = Quest::whereId($this->argument('quest'))->with(['hints.users', 'records.user'])->first();
        if ($quest === null) {
            $this->error('Quest Not Found!');
        } else {
            $records = $quest->records()->with('user')->get();
            foreach ($records as $record) {
                /** @var Record $record */
                // 檢查Flag
                $status = $this->questService->judge($quest, $record->flag, $record->user->id);
                $record->update([
                    'is_correct' => $status['is_correct'],
                    'point'      => $status['point'],
                ]);
                // 檢查首殺
                if ($status['is_correct']) {
                    $this->questService->checkFirst($quest, $record);
                }
            }
        }
    }
}
