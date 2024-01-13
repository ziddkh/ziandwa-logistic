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
        Schema::create('shipment_items', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->unsignedBigInteger('shipment_header_id')->index()->nullable();
            $table->date('departure_date')->index()->nullable();
            $table->date('expected_arrival_date')->index()->nullable();
            $table->string('ship_name')->index()->nullable();
            $table->decimal('width')->nullable();
            $table->decimal('length')->nullable();
            $table->decimal('height')->nullable();
            $table->decimal('vol_weight', 10, 3)->nullable();
            $table->bigInteger('price')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('shipment_items');
    }
};
