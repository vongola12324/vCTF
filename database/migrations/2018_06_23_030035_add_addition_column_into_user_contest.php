<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdditionColumnIntoUserContest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_contest', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_hidden')->defalut(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_contest', function (Blueprint $table) {
            $table->dropColumn(['is_admin', 'is_hidden']);
        });
    }
}
