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
        Schema::table('shipper_items', function (Blueprint $table) {
            $table->decimal('vol_weight', 8, 3)->change();
        });

        Schema::table('shipper_invoice_items', function (Blueprint $table) {
            $table->decimal('vol_weight', 8, 3)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipper_items', function (Blueprint $table) {
            $table->decimal('vol_weight', 8, 2)->change();
        });

        Schema::table('shipper_invoice_items', function (Blueprint $table) {
            $table->decimal('vol_weight', 8, 2)->change();
        });
    }
};
