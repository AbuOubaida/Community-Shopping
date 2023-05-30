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
        Schema::table('shipping_charges', function (Blueprint $table) {
            $table->after('location_name',function ($table){
                $table->string('location_type')->comment('1=country, 2=division, 3=district, 4=upazila, 5=union');
            });
            $table->after('amount',function ($table){
                $table->string('create_by')->nullable();
                $table->string('update_by')->nullable();
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
        Schema::table('shipping_charges', function (Blueprint $table) {
            //
        });
    }
};
