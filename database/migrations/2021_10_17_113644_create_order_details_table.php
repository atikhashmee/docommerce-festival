<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('original_store_id');
            $table->unsignedBigInteger('store_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('original_product_id');
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('product_variant_id')->nullable();
            $table->unsignedBigInteger('free_delivery')->nullable();
            $table->string('product_name');
            $table->text('product_variant_details')->nullable()->comment('variant json data');
            $table->decimal('product_unit_price', 10, 2);
            $table->decimal('additional_delivery_charge', 10, 2)->default(0.00)->comment('unit amount');
            $table->decimal('discount_amount', 10, 2)->default(0)->comment('unit discount amount');
            $table->unsignedInteger('product_quantity')->default(1);
            $table->unsignedInteger('returned_quantity')->default(0)->comment('if admin return');
            $table->unsignedInteger('final_quantity');
            $table->decimal('sub_total', 10, 2)->default(0)->comment('product_unit_price * quantity');
            $table->decimal('total', 10, 2)->default(0)->comment('(sub_total + additional_delivery_charge) - discount_amount');
            $table->decimal('returned_amount', 10, 2)->default(0)->comment('if admin return');
            $table->decimal('final_amount', 10, 2)->default(0)->comment('total - returned_amount');
            $table->decimal('merchant_commission', 10, 2)->default(0);
            $table->decimal('product_cost', 10, 2)->default(0)->comment('stock out product cost');
            $table->unsignedBigInteger('order_detail_id')->nullable()->comment('if by one get free');
            $table->timestamp('rejected_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->enum('status', ['Pending', 'In Progress', 'Ready to Ship', 'Shipped', 'Canceled & Refund', 'Delivered'])->default('Pending');
            $table->foreign('order_id')->on('orders')->references('id')->onDelete('cascade');
            $table->foreign('store_id')->on('stores')->references('id')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
}
