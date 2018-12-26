<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVotesToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->index()->default('')->comment('用户联系方式');
            $table->string('province')->default('')->comment('省');
            $table->string('city')->default('')->comment('市');
            $table->string('district')->default('')->comment('县');
            $table->string('birthday')->default('')->comment('生日');
            $table->string('detail',500)->default('')->comment('用户详细地址');
            $table->enum('sex',['男','女'])->default('男')->comment('用户性别');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('province');
            $table->dropColumn('city');
            $table->dropColumn('district');
            $table->dropColumn('detail');
            $table->dropColumn('sex');
            $table->dropColumn('birthday');
    });
    }
}
