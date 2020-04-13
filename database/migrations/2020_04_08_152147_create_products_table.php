<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('p_name');
            $table->string('p_code')->nullable();
            $table->bigInteger('category_id');
            $table->bigInteger('supplier_id')->nullable();
            $table->integer('buying_price')->nullable();
            $table->string('selling_price');
            $table->date('buying_date')->nullable();
            $table->integer('p_quantity')->default(0);
            $table->string('root')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('products');
    }
}
