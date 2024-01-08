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
        Schema::table('sell_lines', function (Blueprint $table) {
            $table->decimal('stock_sell_price', 15, 4)->nullable();
            $table->decimal('stock_dollar_sell_price', 15, 4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sell_lines', function (Blueprint $table) {
            //
        });
    }
};
