<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('purchase_id');
            $table->unsignedInteger('product_id');

            $table->index(['purchase_id'], 'fk_purchase_items_purchases_idx');
            $table->index(['product_id'], 'fk_purchase_items_products_idx');

            $table->foreign('purchase_id', 'fk_purchase_items_purchases_idx')
                ->references('id')->on('purchases')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('product_id', 'fk_purchase_items_products_idx')
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
        Schema::dropIfExists('purchase_items');
    }
}
