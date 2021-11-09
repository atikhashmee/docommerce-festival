<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('festival_id');
            $table->unsignedBigInteger('original_product_id');
            $table->unsignedBigInteger('store_id');
            $table->string('name');
            $table->enum('discount_type', ['percentage', 'fixed']);
            $table->decimal('discount_amount', 10, 2);
            $table->string('opt1_name');
            $table->string('opt2_name')->nullable();
            $table->string('opt3_name')->nullable();
            $table->string('opt1_value');
            $table->string('opt2_value')->nullable();
            $table->string('opt3_value')->nullable();
            $table->decimal('old_price', 10, 2)->nullable();
            $table->decimal('price', 10, 2);
            $table->unsignedBigInteger('quantity');
            $table->string('barcode')->nullable();
            $table->foreign('product_id')->on('products')->references('id')->onDelete('cascade');
            $table->foreign('festival_id')->on('festivals')->references('id')->onDelete('cascade');
            $table->foreign('store_id')->on('stores')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('product_variants');
    }
}
