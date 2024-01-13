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
        Schema::create('shipment_headers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->string('shipment_number')->unique()->index()->nullable();
            $table->string('recipient_name')->index()->nullable();
            $table->string('recipient_phone')->index()->nullable();
            $table->string('recipient_address')->index()->nullable();
            $table->unsignedBigInteger('type_of_shipment_id')->index()->nullable();
            $table->unsignedBigInteger('destination_id')->index()->nullable();
            $table->string('destination_cost')->nullable();
            $table->string('status')->index()->nullable();
            $table->string('remarks')->nullable();
            $table->decimal('total_vol_weight', 10, 3)->nullable();
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
        Schema::dropIfExists('shipment_headers');
    }
};
