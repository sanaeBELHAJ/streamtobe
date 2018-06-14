<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pseudo')->unique();
            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->integer('status')->default(0);
            $table->text('description');
            $table->integer('activated')->default(0);
            $table->string('password');
            $table->string('avatar')->default('users/default.png');
            $table->string('confirmation_code')->nullable();
            $table->rememberToken();
            $table->timestamps();
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
        Schema::dropIfExists('users');
    }
}
