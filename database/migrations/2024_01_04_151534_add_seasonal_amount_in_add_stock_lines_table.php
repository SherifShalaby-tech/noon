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
        Schema::table('add_stock_lines', function (Blueprint $table) {
            $table->decimal('seasonal_discount_amount', 15, 4)->nullable();
            $table->decimal('annual_discount_amount', 15, 4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('add_stock_lines', function (Blueprint $table) {
            //
        });
    }
};
