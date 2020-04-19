<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_header', function (Blueprint $table) {
            $table->id();
            $table->string('building_title');
            $table->string('building_slug');
            $table->text('building_address');
            $table->text('building_desc');
            $table->string('building_lat_coordinate');
            $table->string('building_long_coordinate');
            $table->integer('created_by');
            $table->timestamps();
            $table->integer('updated_by');
        });

        Schema::create('building_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('building_header_id');
            $table->string('name');
            $table->enum('rent_duration', ['D', 'W', 'M', 'Q', 'Y'])->default('D');
            $table->bigInteger('rent_price');
            $table->integer('created_by');
            $table->timestamps();
            $table->integer('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('building_header');
        Schema::dropIfExists('building_detail');
    }
}
