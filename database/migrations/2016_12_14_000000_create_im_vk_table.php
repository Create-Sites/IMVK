<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImVkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('im_vk', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('all_msg_num')->default('0');
            $table->integer('user_id');
            $table->integer('im_user_id');
            $table->integer('msg_num')->default('0');
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
        Schema::dropIfExists('im_vk');
    }
}