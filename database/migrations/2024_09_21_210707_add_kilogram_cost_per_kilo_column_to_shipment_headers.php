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
        Schema::table('shipment_headers', function (Blueprint $table) {
            $table->bigInteger(column: 'cost_per_kg')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipment_headers', function (Blueprint $table) {
            $table->dropColumn([
                'cost_per_kg'
            ]);
        });
    }
};
