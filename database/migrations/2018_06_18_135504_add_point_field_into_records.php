<?php

use App\Quest;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPointFieldIntoRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('records', function (Blueprint $table) {
            $table->unsignedInteger('point')->default(0)->after('is_first');
        });
        $quests = Quest::all();
        foreach ($quests as $quest) {
            Artisan::call('quest:rejudge', ['quest' => $quest->id]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('records', function (Blueprint $table) {
            $table->dropColumn('point');
        });
    }
}
