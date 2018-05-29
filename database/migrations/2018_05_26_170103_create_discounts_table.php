<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('description');
            $table->decimal('minimum_customer_revenue', 8, 2)->nullable();
            $table->decimal('total_order_discount_percent', 8, 2)->nullable();
            $table->integer('multiple_products_same_category')->nullable();
            $table->integer('free_category_products')->nullable();
            $table->integer('minimum_quantity_same_category')->nullable();
            $table->decimal('cheapest_product_discount_percent', 8, 2)->nullable();

            $table->unsignedInteger('category_id')->nullable();
            $table->foreign('category_id')
                ->references('id')
                ->on('category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount');
    }
}
