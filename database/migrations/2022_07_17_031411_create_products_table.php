<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('uuid');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('description_html')->nullable();
            $table->float('price')->nullable();
            $table->string('asin')->unique();
            $table->string('seller_by')->nullable();
            $table->string('sender_on_store')->nullable();
            $table->string('currency')->nullable();
            $table->string('publish_date')->nullable();
            $table->string('evaluation')->nullable();
            $table->string('best_seller_rank')->nullable();
            $table->string('link_concurrent_product')->nullable();
            $table->string('categories')->nullable();
            $table->json('concurrent_products')->nullable();
            $table->json('images')->nullable();
            $table->json('related_products')->nullable();
            $table->json('product_bought_together')->nullable();
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
};
