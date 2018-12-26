<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';//引擎设置
            $table->increments('id');
            $table->unsignedInteger('order_id')->index()->default(0)->comment('订单 id');
            $table->string('title')->default('')->comment('商品名称');
            $table->string('pic')->default('')->comment('商品图片');
            $table->string('spec')->default('')->comment('商品规格');
            $table->unsignedInteger('num')->default(0)->comment('购买数量');
            $table->decimal('price')->default(0)->comment('商品单价');
            //unsignedInteger 非负整型 decimal整数位和小数位的类型
            //good_id商品  spec_id规格
            $table->unsignedInteger('good_id')->default(0)->comment('商品 id');
            $table->unsignedInteger('spec_id')->default(0)->comment('规格 id');
            //foreign外键  references约束
            $table->foreign('order_id')
                ->references('id')->on('orders')
                ->onDelete('cascade');
            $table->timestamps();
        },'订单详情表');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
}
