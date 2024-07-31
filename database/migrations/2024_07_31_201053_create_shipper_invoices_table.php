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
        Schema::create('shipper_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shipper_payment_id')->index()->nullable();
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

            $table->string('payment_number', 150)->index()->nullable();
            $table->string('payment_method', 50)->index()->nullable();
            $table->string('payment_status', 50)->index()->nullable();
            $table->bigInteger('payment_amount')->nullable();
            $table->bigInteger('remaining_payment_amount')->nullable();

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
        Schema::dropIfExists('shipper_invoices');
    }
};
