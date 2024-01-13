<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_headers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->unsignedBigInteger('shipment_header_id')->index()->nullable();
            $table->string('payment_number')->unique()->index()->nullable();
            $table->string('payment_method')->index()->nullable();
            $table->string('payment_status')->index()->nullable();
            $table->bigInteger('discount')->default(0)->nullable();
            $table->bigInteger('total_payment')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_headers');
    }
};
