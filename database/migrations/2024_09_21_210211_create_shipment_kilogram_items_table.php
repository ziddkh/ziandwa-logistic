<?php

use App\Models\Shipment\ShipmentHeader;
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
        Schema::create('shipment_kilogram_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ShipmentHeader::class)->nullable();
            $table->decimal('width')->nullable();
            $table->decimal('length')->nullable();
            $table->decimal('height')->nullable();
            $table->decimal('vol_weight', 10, 3)->nullable();
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
        Schema::dropIfExists('shipment_kilogram_items');
    }
};
