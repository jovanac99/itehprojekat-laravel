<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sats', function (Blueprint $table) {
            $table->id();
            $table->string('brend');
            $table->string('model');
            $table->string('slika');
            $table->double('cena');
            $table->string('pol');
            $table->string('narukvica');
            $table->string('mehanizam');
            $table->string('garancija');
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
        Schema::dropIfExists('sats');
    }
}
