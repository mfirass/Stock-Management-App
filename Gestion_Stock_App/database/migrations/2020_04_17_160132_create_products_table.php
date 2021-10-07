<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('libelle');
            $table->string('reference');
            $table->string('marque');
            $table->string('descriptif_technique');
            $table->integer('tva');
            $table->double('prix_achat', 12, 2)->nullable();
            $table->double('prix_vente_grossite', 12, 2)->nullable();
            $table->double('prix_vente_detaillant', 12, 2)->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
