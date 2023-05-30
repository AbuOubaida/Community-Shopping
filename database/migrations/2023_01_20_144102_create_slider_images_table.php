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
        Schema::create('slider_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_id');
            $table->foreign('created_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->integer('title_show')->default(0)->comment('If 1 then show else not show');
            $table->integer('status')->default(1)->comment('If 1 then show else not show');
            $table->integer('deleteStatus')->default(0)->comment('If 1 then deleted else not deleted');
            $table->string('quotation')->nullable();
            $table->integer('quotation_show')->default(0)->comment('If 1 then show else not show');
            $table->string('heading1')->nullable();
            $table->integer('heading1_show')->default(1)->comment('If 1 then show else not show');
            $table->string('heading2')->nullable();
            $table->integer('heading2_show')->default(0)->comment('If 1 then show else not show');
            $table->string('paragraph')->nullable();
            $table->integer('paragraph_show')->default(1)->comment('If 1 then show else not show');
            $table->string('button_title')->nullable();
            $table->string('button_link')->nullable();
            $table->integer('button_show')->default(1)->comment('If 1 then show else not show');
            $table->text('image_name')->nullable();
            $table->text('source_url')->default(url("assets/slider-image/"));
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
        Schema::dropIfExists('slider_images');
    }
};
