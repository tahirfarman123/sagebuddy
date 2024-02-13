<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportFullfillOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_fullfill_orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('name')->nullable();
            $table->bigInteger('trackingid')->nullable();
            $table->string('tracking_url')->nullable();
            $table->integer('fullfill')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('import_fullfill_orders');
    }
}
