<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBrandsTable extends Migration {

	public function up()
	{
		Schema::create('brands', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('name');
			$table->integer('created_by')->nullable();
			$table->integer('edited_by');
			$table->integer('deleted_by')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('brands');
	}
}