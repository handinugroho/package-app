<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConnoteKolisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connote_kolis', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('connote_id');
            $table->string('code');
            $table->string('description');
            $table->text('awb_url');
            $table->unsignedBigInteger('formula_id')->nullable();
            $table->json('surcharge');
            $table->bigInteger('length');
            $table->bigInteger('chargeable_weight');
            $table->bigInteger('width');
            $table->bigInteger('height');
            $table->bigInteger('volume');
            $table->bigInteger('weight');
            $table->json('custom_field');
            $table->softDeletes();
            $table->timestamps();

            //
            $table->foreign('connote_id')->references('id')->on('connotes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('connote_kolis');
    }
}
