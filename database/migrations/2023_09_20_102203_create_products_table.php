<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('product_category_id');
            $table->string('image')->nullable();
            $table->decimal('buying_price', 13, 2)->default(0.00);
            $table->decimal('selling_price', 13, 2)->default(0.00);
            $table->string('unit')->nullable();

            $table->index(['product_category_id'], 'fk_products_product_categories_idx');

            $table->foreign('product_category_id', 'fk_products_product_categories_idx')
                ->references('id')->on('product_categories')
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
        Schema::dropIfExists('products');
    }
}
