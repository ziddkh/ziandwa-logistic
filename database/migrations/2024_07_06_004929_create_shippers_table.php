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
        Schema::create('shippers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->string('document_number', 25)->index()->nullable(); // TSLSHPMYYYYMMDDXXXX
            $table->string('name', 100)->index()->nullable();
            $table->date('departure_date')->index()->nullable();
            $table->unsignedBigInteger('destination_id')->index()->nullable();
            $table->string('destination_type', 10)->index()->nullable();
            $table->string('destination_name', 100)->index()->nullable();
            $table->bigInteger('destination_cost')->nullable();
            $table->string('harbor_name', 100)->index()->nullable();
            $table->string('ship_name', 100)->index()->nullable();
            $table->unsignedBigInteger('type_of_shipment_id')->index()->nullable();
            $table->string('type_of_shipment_name', 20)->nullable();
            $table->bigInteger('type_of_shipment_freight')->nullable();
            $table->string('status', 50)->index()->nullable();
            $table->integer('total_colly')->nullable();
            $table->decimal('total_vol_weight')->nullable();
            $table->bigInteger('total_price')->nullable();
            $table->timestamps();
            $table->softDeletes()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shippers');
    }
};
