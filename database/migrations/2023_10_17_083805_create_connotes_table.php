<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConnotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connotes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->bigInteger('number');
            $table->string('service');
            $table->bigInteger('service_price');
            $table->bigInteger('amount');
            $table->string('code');
            $table->string('booking_code');
            $table->unsignedBigInteger('connote_state_id');
            $table->string('zone_code_from');
            $table->string('zone_code_to');
            $table->bigInteger('surcharge_amount')->nullable();
            $table->unsignedBigInteger('package_id');
            $table->bigInteger('actual_weight');
            $table->bigInteger('volume_weight');
            $table->bigInteger('chargeable_weight');
            $table->unsignedBigInteger('organization_id');
            $table->bigInteger('total_package');
            $table->bigInteger('sla_day');
            $table->string('location_name');
            $table->string('location_type');
            $table->morphs('source_tariff');
            $table->json('pod')->nullable();
            $table->json('history')->nullable();

            $table->softDeletes();
            $table->timestamps();

            // FK
            $table->foreign('connote_state_id')->references('id')->on('connote_states');
            $table->foreign('package_id')->references('id')->on('packages');
            $table->foreign('organization_id')->references('id')->on('organizations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('connotes');
    }
}
