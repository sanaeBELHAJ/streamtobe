<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStreamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stb_streams', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('streamer_id')->unsigned();
            $table->foreign('streamer_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');

            $table->integer('type_id')->unsigned();
            $table->foreign('type_id')
                    ->references('id')
                    ->on('stb_types')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');

            $table->string('titre');
            $table->integer('status')->default(0);
            $table->rememberToken();
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
        Schema::table('stb_streams', function(Blueprint $table) {
			$table->dropForeign('streamer_id');
			//$table->dropForeign('streams_user_id_foreign');
		});
        Schema::dropIfExists('stb_streams');
    }
}
