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
        Schema::create('shipper_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shipper_invoice_id')->index()->nullable();
            $table->string('recipient_name')->index()->nullable();
            $table->decimal('vol_weight')->nullable();
            $table->integer('colly')->nullable();
            $table->bigInteger('price')->nullable();
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
        Schema::dropIfExists('shipper_invoice_items');
    }
};
