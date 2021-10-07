<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id');
            $table->double('salaires', 12, 2)->nullable();
            $table->double('loyers', 12, 2)->nullable();
            $table->double('assurance', 12, 2)->nullable();
            $table->double('frais_vehicule', 12, 2)->nullable();
            $table->double('frais_emballage', 12, 2)->nullable();
            $table->double('conception', 12, 2)->nullable();
            $table->double('autres', 12, 2)->nullable();
            $table->timestamps();

            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('charges');
    }
}
