<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stb_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();

            $table->integer('theme_id')->unsigned();
            $table->foreign('theme_id')
                    ->references('id')
                    ->on('stb_themes')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');

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
        Schema::dropIfExists('stb_types');
    }
}
