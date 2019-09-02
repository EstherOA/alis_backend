<?php

use Illuminate\Support\Facades\Schema;
//use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Phaza\LaravelPostgis\Schema\Blueprint;


class CreateSpRegionalBoundariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sp_regional_boundaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('objectid')->nullable();
            $table->integer('regioid')->nullable();
            $table->integer('src_info')->nullable();
            $table->date('src_date')->nullable();
            $table->double('shape_leng')->nullable();
            $table->double('shape_area')->nullable();
            $table->string('reg_name', 50)->nullable();
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
        Schema::dropIfExists('sp_regional_boundaries');
    }
}
