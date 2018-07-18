<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMusicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stb_musics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('mark')->nullable();
            $table->string('qtty_votes')->nullable();
            $table->integer('status')->default(1);
            $table->string('gift_viewer')->nullable();
            
            $table->integer('stream_id')->unsigned();
            $table->foreign('stream_id')
                    ->references('id')
                    ->on('stb_streams')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');

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
        Schema::dropIfExists('stb_musics');
    }
}
