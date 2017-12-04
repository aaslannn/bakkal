<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePosaccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posaccounts', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('bankname');
            $table->string('cardname');
            $table->smallInteger('status');
            $table->smallInteger('mainpos');
            $table->smallInteger('mobil');
            $table->smallInteger('payu');
            $table->string('isyerino')->nullable();
            $table->string('terminalno')->nullable();
            $table->string('kullanici')->nullable();
            $table->string('sifre')->nullable();
            $table->smallInteger('3dsecure');
            $table->smallInteger('bonus');
            $table->smallInteger('otorizasyon');
            $table->smallInteger('taksit');
            $table->decimal('mintaksit',8,2)->nullable();
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
        Schema::drop('slides');
    }
}
