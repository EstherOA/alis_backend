<?php

use Illuminate\Support\Facades\Schema;
//use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Phaza\LaravelPostgis\Schema\Blueprint;

class CreateSpCadastralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sp_cadastrals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ccno', 254)->nullable();
            $table->string('ref_no', 80)->nullable();
            $table->string('reg_no', 80)->nullable();
            $table->string('cert_no', 80)->nullable();
            $table->string('a_name', 80)->nullable();
            $table->string('grantor', 80)->nullable();
            $table->string('locality', 80)->nullable();
            $table->string('job_number', 80)->nullable();
            $table->string('type_instr', 80)->nullable();
            $table->string('date_instr', 254)->nullable();
            $table->string('considerat', 80)->nullable();
            $table->string('purpose', 80)->nullable();
            $table->string('date_com', 254)->nullable();
            $table->string('term', 80)->nullable();
            $table->string('mul_claim', 80)->nullable();
            $table->string('remarks', 118)->nullable();
            $table->string('t_code', 254)->nullable();
            $table->string('label_code', 254)->nullable();
            $table->string('plotted_by', 80)->nullable();
            $table->string('checked_by', 80)->nullable();
            $table->string('plott_date', 10)->nullable();
            $table->polygon('geom', 'GEOMETRY', 3857)->nullable();
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
        Schema::dropIfExists('sp_cadastrals');
    }
}
