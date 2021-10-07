<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactureDemandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facture_demandes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_client');
            $table->double('total', 12, 2);
            $table->double('montant_paye', 12, 2);
            $table->timestamps();

            $table->foreign('id_client')->references('id')->on('clients')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facture_demandes');
    }
}
