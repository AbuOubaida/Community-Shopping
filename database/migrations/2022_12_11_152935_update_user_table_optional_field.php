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
            $table->after('status',function ($table){
                $table->string('fname')->nullable();
                $table->string('lname')->nullable();
            });
            $table->after('email',function ($table){
                $table->string('phone')->nullable();
                $table->string('home')->nullable();
                $table->string('village')->nullable();
                $table->string('word')->nullable();
                $table->string('union')->nullable();
                $table->string('upazila')->nullable();
                $table->string('district')->nullable();
                $table->string('zip_code')->nullable();
                $table->string('division')->nullable();
                $table->string('country')->nullable();
            });
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
