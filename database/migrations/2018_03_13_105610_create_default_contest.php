<?php

use App\Contest;
use App\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefaultContest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $contest = Contest::create([
            'name'         => 'Public',
            'display_name' => '公開競賽',
            'start_at'     => null,
            'end_at'       => null,
        ]);
        Setting::create([
            'key'  => 'current_contest',
            'type' => 'string',
            'data' => $contest->name,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Setting::whereKey('current_contest')->first()->delete();
        Contest::whereName('Public')->first()->delete();
    }
}
