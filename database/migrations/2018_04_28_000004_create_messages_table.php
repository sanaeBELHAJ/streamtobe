<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stb_messages', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_exped')->unsigned();
            $table->foreign('user_exped')
                    ->references('id')
                    ->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');

            $table->integer('user_receiv')->unsigned();
            $table->foreign('user_receiv')
                    ->references('id')
                    ->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');

            $table->text('message');
            $table->string('status')->nullable();
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->engine = 'InnoDB';	 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stb_messages');
    }
}
