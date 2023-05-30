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
        Schema::create('communities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("owner_id");
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger("creater_id");
            $table->foreign('creater_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('community_name');
            $table->integer('community_type');
            $table->integer('status')->default(2)->comment('5 = inactive, 2 = incomplete, 1 = active');
            $table->integer('delete_status')->default(0)->comment('0 = not deleted, 1 = deleted');
            $table->string('community_phone');
            $table->string('community_email')->nullable();
            $table->string('home')->nullable();
            $table->string('village')->nullable();
            $table->string('word')->nullable();
            $table->string('union')->nullable();
            $table->string('upazila')->nullable();
            $table->string('district')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('division')->nullable();
            $table->string('country')->nullable();
            $table->text('community_profile_image')->nullable();
            $table->string('profile_image_path')->nullable();
            $table->text('community_cover_image')->nullable();
            $table->string('cover_image_path')->nullable();
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
        Schema::dropIfExists('communities');
    }
};
