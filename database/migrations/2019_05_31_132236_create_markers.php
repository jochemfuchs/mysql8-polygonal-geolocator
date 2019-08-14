<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarkers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('markers', function (Blueprint $table) {
            $srid = env('SPATIAL_REF_ID', 4326);

            $table->bigIncrements('id');
            $table->string('name');
            $table->point('coordinate', $srid);
            $table->string('lat')->virtualAs('ST_X(coordinate)');
            $table->string('lon')->virtualAs('ST_Y(coordinate)');

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
        Schema::dropIfExists('markers');
    }
}
