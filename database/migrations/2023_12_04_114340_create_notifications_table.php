<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // ++++++++++++++++++++++ up() ++++++++++++++++++++++
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }
    // ++++++++++++++++++++++ down() ++++++++++++++++++++++
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
