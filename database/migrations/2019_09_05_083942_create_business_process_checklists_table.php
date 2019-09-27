<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessProcessChecklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_process_checklists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->boolean('option')->default(false);
            $table->integer('business_process_id');
            $table->integer('business_sub_process_id');
            $table->integer('priority')->nullable();
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
        Schema::dropIfExists('business_process_checklists');
    }
}
