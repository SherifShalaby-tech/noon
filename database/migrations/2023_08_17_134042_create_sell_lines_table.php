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
        Schema::create('sell_lines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->foreign('transaction_id')->references('id')->on('transaction_sell_lines')->onDelete('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->decimal('quantity', 15, 4);
            $table->decimal('quantity_returned', 15, 4)->default(0);
            $table->decimal('purchase_price', 15, 4)->nullable();
            $table->decimal('dollar_purchase_price', 15, 4)->nullable();
            $table->decimal('sell_price', 15, 4)->nullable();
            $table->decimal('dollar_sell_price', 15, 4)->nullable();
            $table->decimal('sub_total', 15, 4);
            $table->boolean('point_earned')->default(0);
            $table->boolean('point_redeemed')->default(0);
            $table->string('product_discount_type')->nullable();
            $table->decimal('product_discount_value', 15, 4)->default(0);
            $table->decimal('product_discount_category', 15, 4)->default(0);
            $table->decimal('product_discount_amount', 15, 4)->default(0);
            $table->unsignedBigInteger('tax_id')->nullable();
            $table->string('tax_method')->nullable();
            $table->decimal('item_tax', 15, 4)->default(0);
            $table->decimal('tax_rate', 15, 4)->default(0);
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
        Schema::dropIfExists('sell_lines');
    }
};
