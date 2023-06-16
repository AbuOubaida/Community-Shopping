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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id');
            $table->string('order_id');
            $table->bigInteger('customer_id');
            $table->bigInteger('delivery_person_id')->nullable();
            $table->string('delivery_address');
            $table->string('c_name');
            $table->string('c_phone');
            $table->string('c_email');
            $table->integer('order_status')->default(1);
            $table->integer('order_complete_status')->default(0);
            $table->string('product_count');
            $table->string('price');
            $table->string('payment_method');
            $table->string('shipping_charge');
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
        Schema::dropIfExists('orders');
    }
};
