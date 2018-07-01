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

            $table->string('title');
            $table->integer('status')->default(0);
            $table->rememberToken();
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
        Schema::table('stb_streams', function(Blueprint $table) {
			$table->dropForeign('streamer_id');
		});
        Schema::dropIfExists('stb_streams');
    }
}
