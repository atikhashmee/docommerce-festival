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
            $table->id();
            $table->unsignedBigInteger('store_id');
            $table->unsignedBigInteger('festival_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('original_product_sequence_id')->default(0);
            $table->unsignedBigInteger('original_product_id');
            $table->unsignedBigInteger('original_store_id');
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('is_feature')->default(false);
            $table->boolean('is_new_arrival')->default(false);
            $table->decimal('price', 10, 2)->default(00.00);
            $table->decimal('old_price', 10, 2)->default(00.00);
            $table->decimal('weight', 10, 2)->default(00.00);
            $table->unsignedBigInteger('quantity');
            $table->enum('section_type', ['hot_deals', 'new_arrival']);
            $table->string('original_product_img')->nullable();
            $table->text('other_images')->nullable()->comment('All images');
            $table->string('original_product_url')->nullable();
            $table->enum('discount_type', ['percentage', 'fixed']);
            $table->decimal('discount_amount', 10, 2);
            $table->string('visit_count')->default(0);
            $table->string('page_title')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->text('meta_description')->nullable();
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
