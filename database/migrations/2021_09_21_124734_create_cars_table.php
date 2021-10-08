<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('nazwa');
            $table->string('rejestracja');
            $table->integer('stan_licznika');
            $table->string('marka')->nullable();
            $table->string('model')->nullable();
            $table->integer('stan_licznika_wymiana_oleju')->nullable();
            $table->date('ostatni_przeglad_data')->nullable();
            $table->string('kolor')->nullable();
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
        Schema::dropIfExists('cars');
    }
}
