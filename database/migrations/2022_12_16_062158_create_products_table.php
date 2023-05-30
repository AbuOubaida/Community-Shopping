<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('p_status')->default(0);
            $table->integer('offer_status')->default(0);
            $table->bigInteger('vendor_id');
            $table->bigInteger('creater_id');
            $table->bigInteger('updater_id')->nullable();
            $table->bigInteger('category_id');
            $table->string("p_name");
            $table->string("p_price");
            $table->string("p_details")->nullable();
            $table->integer("p_quantity");
            $table->string("p_image")->nullable();
            $table->integer("p_slider_image")->default(0);
            $table->string("offer_percentage")->nullable();
            $table->integer("offer_quantity")->nullable();
            $table->string("offer_start_time")->nullable();
            $table->string("offer_end_time")->nullable();
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
        Schema::dropIfExists('products');
    }
};
