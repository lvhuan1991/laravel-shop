<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';//引擎
            $table->increments('id');
            $table->string('name')->default('')->comment('栏目名称');
            $table->unsignedInteger('pid')->default(0)->comment('父级标号');
            // id        name     pid(parent_id)
            // 1         服装      0
            // 2         裤子      1
            // 3         上衣      1
            // 4         卫衣      3
            $table->timestamps();
        },'栏目分类表');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
