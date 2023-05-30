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
        Schema::table('users', function (Blueprint $table) {
            $table->after('lname',function ($table){
                $table->integer('gender')->comment('1=male, 2=female 3=other');
                $table->string('religion')->nullable();
                $table->dateTime('dob')->nullable();
            });
            $table->string('img_path')->nullable();
            $table->string('img_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
