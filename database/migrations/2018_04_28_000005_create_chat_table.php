<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stb_chats', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('stream_id')->unsigned();
            $table->foreign('stream_id')
                    ->references('id')
                    ->on('stb_streams')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');
            
            $table->string('message')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('stb_chat');
    }
}
