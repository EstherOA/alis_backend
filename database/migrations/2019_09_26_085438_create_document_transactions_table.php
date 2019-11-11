<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('file_id');
            $table->integer('from_id');
            $table->string('from_name');
            $table->integer('to_id');
            $table->string('to_name');
            $table->text('from_remarks');
            $table->text('to_remarks')->nullable();
            $table->string('department_from');
            $table->string('department_to');
            $table->integer('department_to_id');
            $table->integer('department_from_id');
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
        Schema::dropIfExists('document_transactions');
    }
}
