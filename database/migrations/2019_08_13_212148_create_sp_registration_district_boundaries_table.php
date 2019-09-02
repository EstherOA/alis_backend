<?php

use Illuminate\Support\Facades\Schema;
//use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Phaza\LaravelPostgis\Schema\Blueprint;

class CreateSpRegistrationDistrictBoundariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sp_registration_district_boundaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('objectid')->nullable();
            $table->string('regioid', 2)->nullable();
            $table->string('src_info', 20)->nullable();
            $table->date('src_date')->nullable();
            $table->double('shape_leng')->nullable();
            $table->double('shape_area')->nullable();
            $table->string('reg_name', 20)->nullable();
            $table->string('distriid', 3)->nullable();
            $table->multipolygon('geom', 'GEOMETRY', 3857)->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('sp_registration_district_boundaries');
    }
}
