<?php

use Illuminate\Support\Facades\Schema;
//use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Phaza\LaravelPostgis\Schema\Blueprint;

class CreateSpParcelSmdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sp_parcel_smds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ccno', 254)->nullable();
            $table->string('ref_no', 254)->nullable();
            $table->string('reg_no', 254)->nullable();
            $table->string('cert_no', 254)->nullable();
            $table->string('a_name', 254)->nullable();
            $table->string('grantor', 254)->nullable();
            $table->string('locality', 254)->nullable();
            $table->string('job_number', 254)->nullable();
            $table->string('type_instr', 254)->nullable();
            $table->date('date_instr')->nullable();
            $table->string('considerat', 254)->nullable();
            $table->string('purpose', 254)->nullable();
            $table->date('date_com')->nullable();
            $table->string('term', 254)->nullable();
            $table->string('mul_claim', 254)->nullable();
            $table->string('remarks', 254)->nullable();
            $table->integer('t_code')->nullable();
            $table->integer('label_code')->nullable();
            $table->string('plotted_by', 254)->nullable();
            $table->string('checked_by', 254)->nullable();
            $table->string('date_plott', 254)->nullable();
            $table->string('plan_no', 254)->nullable();
            $table->integer('case_id')->nullable();
            $table->multipolygon('geom', 'GEOMETRY', 3857)->nullable();
            $table->string('source', 100)->nullable();
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
        Schema::dropIfExists('sp_parcel_smds');
    }
}
