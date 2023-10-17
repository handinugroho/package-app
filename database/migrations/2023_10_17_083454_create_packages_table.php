<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('organization_id');
            $table->string('customer_name', 255);
            $table->string('customer_code', 255);
            $table->bigInteger('transaction_order');
            $table->string('transaction_code', 255);
            $table->bigInteger('transaction_amount');
            $table->bigInteger('transaction_discount')->default(0);
            $table->string('transaction_additional_field', 255)->default("");
            $table->bigInteger('transaction_cash_amount')->default(0);
            $table->bigInteger('transaction_cash_change')->default(0);
            $table->unsignedBigInteger('payment_type_id');
            $table->string('payment_type_name');
            $table->unsignedBigInteger('origin_data_id');
            $table->unsignedBigInteger('destination_data_id');
            $table->json('custom_field')->nullable();
            $table->json('customer_attribute')->nullable();
            $table->json('current_location')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->foreign('payment_type_id')->references('id')->on('payment_types');
            $table->foreign('origin_data_id')->references('id')->on('customers');
            $table->foreign('destination_data_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
}
