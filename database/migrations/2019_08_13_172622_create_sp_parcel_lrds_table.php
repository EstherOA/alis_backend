<?php

use Illuminate\Support\Facades\Schema;
//use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Phaza\LaravelPostgis\Schema\Blueprint;

class CreateSpParcelLrdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sp_parcel_lrds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cc_numb', 254)->nullable();
            $table->string('ref_no', 254)->nullable();
            $table->string('reg_no', 254)->nullable();
            $table->string('cert_no', 254)->nullable();
            $table->string('a_name', 254)->nullable();
            $table->string('grantor', 254)->nullable();
            $table->string('locality', 254)->nullable();
            $table->string('job_number', 254)->nullable();
            $table->string('type_instr', 254)->nullable();
            $table->string('date_ins', 254)->nullable();
            $table->string('considerat', 254)->nullable();
            $table->string('purpose', 254)->nullable();
            $table->string('date_com', 254)->nullable();
            $table->string('term', 254)->nullable();
            $table->string('mul_claim', 254)->nullable();
            $table->string('remarks', 254)->nullable();
            $table->string('t_code', 254)->nullable();
            $table->string('label_code', 254)->nullable();
            $table->string('plotted_by', 254)->nullable();
            $table->string('checked_by', 254)->nullable();
            $table->string('plott_date', 254)->nullable();
            $table->integer('area')->nullable();
            $table->multipolygon('geom', 'GEOMETRY', 3857)->nullable();
            $table->string('source', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sp_parcel_lrds');
    }
}
