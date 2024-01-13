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
            $table->date('departure_date')->index()->nullable()->after('shipment_number');
            $table->date('expected_arrival_date')->index()->nullable()->after('departure_date');
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
            $table->dropColumn('departure_date');
            $table->dropColumn('expected_arrival_date');
        });
    }
};
