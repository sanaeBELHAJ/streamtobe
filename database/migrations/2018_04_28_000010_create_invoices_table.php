<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('paypal_id');
            $table->string('paypal_cart');
            $table->double('amount', 2);
            $table->string('currency');
            $table->string('country');
            $table->string('city');
            $table->text('message')->nullable();
            $table->string('paypal_payer_id');

            $table->integer('viewer_id')->unsigned();
            $table->foreign('viewer_id')
                    ->references('id')
                    ->on('stb_viewers')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');

            $table->string('status')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
