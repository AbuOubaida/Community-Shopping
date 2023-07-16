<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('community_order_from_shops', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->comment('order_products table id');
            $table->foreign('order_id')->references('id')->on('order_products')->onDelete('cascade');
            $table->unsignedBigInteger('shop_id')->comment('shop_infos table id');
            $table->foreign('shop_id')->references('id')->on('shop_infos')->onDelete('cascade');
            $table->unsignedBigInteger('community_id')->comment('communities table id');
            $table->foreign('community_id')->references('id')->on('communities')->onDelete('cascade');
            $table->integer('status')->default(1)->comment('1=shop request community, 2=accept, 3=unable to accept');
            $table->integer('seen_status')->default('0')->comment('0=unseen, 1=seen');
            $table->timestamp('request_time')->useCurrent();
            $table->timestamp('response_time')->useCurrentOnUpdate()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('community_order_from_shop');
    }
};
