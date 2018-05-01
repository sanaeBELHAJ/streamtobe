<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stb_subscribers', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('viewer_id')->unsigned();
            $table->foreign('viewer_id')
                    ->references('id')
                    ->on('stb_viewers')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');

            $table->integer('status')->default(1);
            $table->float('amount', 10, 2)->nullable();
            $table->integer('renewable')->default(0);
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stb_subscribers');
    }
}
