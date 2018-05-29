<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('total', 8, 2);

            $table->unsignedInteger('customer_id');
            $table->foreign('customer_id')
                ->references('id')
                ->on('customer');
        });

        Schema::create('order_has_discount', function (Blueprint $table) {
            $table->unsignedInteger('order_id');
            $table->foreign('order_id')
                ->references('id')
                ->on('order');

            $table->unsignedInteger('discount_id');
            $table->foreign('discount_id')
                ->references('id')
                ->on('discount');

            $table->primary(['order_id', 'discount_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
}
