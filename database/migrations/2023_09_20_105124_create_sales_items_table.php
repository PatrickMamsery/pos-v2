<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sales_id');
            $table->unsignedInteger('product_id');

            $table->index(['sales_id'], 'fk_sales_items_sales_idx');
            $table->index(['product_id'], 'fk_sales_items_products_idx');

            $table->foreign('sales_id', 'fk_sales_items_sales_idx')
                ->references('id')->on('sales')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('product_id', 'fk_sales_items_products_idx')
                ->references('id')->on('products')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_items');
    }
}
