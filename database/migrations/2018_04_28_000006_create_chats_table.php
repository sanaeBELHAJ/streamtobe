<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatsTable extends Migration
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
            
            $table->integer('viewer_id')->unsigned();
            $table->foreign('viewer_id')
                    ->references('id')
                    ->on('stb_viewers')
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
        Schema::dropIfExists('stb_chats');
    }
}
