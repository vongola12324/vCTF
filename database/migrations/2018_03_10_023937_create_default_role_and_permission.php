<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;
    use App\Role;
    use App\Permission;

    class CreateDefaultRoleAndPermission extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            $admin = Role::create([
                'name'         => 'Admin',
                'display_name' => '總管理員',
                'description'  => '主宰此系統至高無上的神明。',
            ]);

            $master = Role::create([
                'name'         => 'Master',
                'display_name' => '御主',
                'description'  => '可以控制單一競賽資訊。',
            ]);

            $permManageMenu = Permission::create([
                'name'         => 'menu.view',
                'display_name' => '檢視管理選單',
                'description'  => '沒有這個權限，你死也看不到管理選單。',
            ]);

            $permContestManage = Permission::create([
                'name'         => 'contest.manage',
                'display_name' => '管理競賽',
                'description'  => '新增、修改、刪除競賽資訊。',
            ]);

            $permQuestManage = Permission::create([
                'name'         => 'quest.manage',
                'display_name' => '管理題目',
                'description'  => '新增、修改、刪除競賽題目。',
            ]);

            $permJudgeManage = Permission::create([
                'name'         => 'judge.manage',
                'display_name' => '管理評審',
                'description'  => '新增、修改、刪除競賽答題評審。',
            ]);

            $admin->attachPermissions([$permManageMenu, $permContestManage, $permQuestManage, $permJudgeManage]);
            $master->attachPermissions([$permManageMenu, $permQuestManage]);
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Permission::whereName('menu.view')->first()->delete();
            Permission::whereName('contest.manage')->first()->delete();
            Permission::whereName('quest.manage')->first()->delete();
            Permission::whereName('judge.manage')->first()->delete();

            Role::whereName('Admin')->first()->delete();
            Role::whereName('Master')->first()->delete();
        }
    }
