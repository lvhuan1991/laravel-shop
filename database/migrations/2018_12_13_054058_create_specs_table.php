<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specs', function (Blueprint $table) {
            $table->engine = 'InnoDB';//引擎
            $table->increments('id');
            $table->string('spec')->default('')->comment('商品规格');
            //integer 整数    unsigned 无符号  ->index 检索
            $table->integer('total')->default(0)->comment('库存');
            //商品详情表约束了商品表通过good_id
            $table->unsignedInteger('good_id')->index()->default(0)->comment('栏目 id');
            $table->foreign('good_id')->references('id')->on('goods')->onDelete('cascade');
            $table->timestamps();
        },'商品详情表');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('specs');
    }
}
