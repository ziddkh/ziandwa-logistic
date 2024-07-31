<?php

use App\Enums\ShipperPaymentStatus;
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
        Schema::create('shipper_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shipper_id')->index()->nullable();
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
        Schema::dropIfExists('shipper_payments');
    }
};
