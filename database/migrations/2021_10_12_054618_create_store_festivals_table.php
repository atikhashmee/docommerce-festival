<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreFestivalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_festivals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('festival_id');
            $table->unsignedBigInteger('store_id');
            $table->string('img')->nullable();
            $table->foreign('festival_id')->on('festivals')->references('id')->onDelete('cascade');
            $table->foreign('store_id')->on('stores')->references('id')->onDelete('cascade');
            $table->unsignedInteger('sort')->default(0);
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
        Schema::dropIfExists('store_festivals');
    }
}
