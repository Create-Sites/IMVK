<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImVkMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('im_vk_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->text('text');
            $table->integer('for_user_id');
            $table->string('pm_read');
            $table->integer('from_user_id');
            $table->string('folder');
            $table->string('attach')->nullable();
            $table->integer('i_m_v_k_id');
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
        Schema::dropIfExists('im_vk_messages');
    }
}