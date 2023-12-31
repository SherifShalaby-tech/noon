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
        Schema::create('product_expiry_damages', function (Blueprint $table) {
            $table->id();
            $table->enum('status',["damage","expiry"]);
            $table->unsignedBigInteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->float("quantity_of_expired_stock_removed");
            $table->float("value_of_removed_stocks");
            $table->timestamp("date_of_removal");
            $table->string("date_of_purchase_of_expired_stock_removed");
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->integer('added_by', )->default(null);
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
        Schema::dropIfExists('product_expiry_damages');
    }
};
