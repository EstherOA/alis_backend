<?php

use Illuminate\Support\Facades\Schema;
//use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Phaza\LaravelPostgis\Schema\Blueprint;


class CreateSpParcelPvlmdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sp_parcel_pvlmds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('remarks', 254)->nullable();
            $table->string('src_date', 254)->nullable();
            $table->string('pvlmdid', 254)->nullable();
            $table->string('map_numb', 254)->nullable();
            $table->string('source', 100)->nullable();
            $table->integer('src_info')->nullable();
            $table->integer('la_tenure')->nullable();
            $table->integer('case_id')->nullable();
            $table->multipolygon('geom', 'GEOMETRY', 3857)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sp_parcel_pvlmds');
    }
}
