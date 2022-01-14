<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string("msg");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger('for');
            $table->timestamps();

            //$table->foreign('user_id')->references('id')->on('users');
            //$table->foreign('chat_id')->references('id')->on('chats');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign('messages_user_id_foreign');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign('messages_chat_id_foreign');
        });
        */
    
        Schema::dropIfExists('messages');
    }
}
