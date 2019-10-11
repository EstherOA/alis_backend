<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLrdPendingApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lrd_pending_applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('licensed_surveyor_uid')->nullable();
            $table->text('licensed_surveyor_number')->nullable();
            $table->text('licensed_surveyor_name')->nullable();
            $table->text('regional_number')->nullable();
            $table->text('job_number')->nullable();
            $table->timestamp('date_of_document')->nullable();
            $table->string('nature_of_instrument',50)->nullable();
            $table->text('lessees_name')->nullable();
            $table->text('lessees_address')->nullable();
            $table->text('lessees_phone_number')->nullable();
            $table->text('email_address')->nullable();
            $table->text('grantors_name')->nullable();
            $table->text('grantors_address')->nullable();
            $table->text('certificate_number')->nullable();
            $table->text('extent')->nullable();
            $table->text('registry_mapref')->nullable();
            $table->text('locality')->nullable();
            $table->text('type_of_interest')->nullable();
            $table->text('type_of_use')->nullable();
            $table->integer('business_process_id')->nullable();
            $table->text('business_process_name')->nullable();
            $table->integer('business_process_sub_id')->nullable();
            $table->text('business_process_sub_name')->nullable();
            $table->text('created_by')->nullable();
            $table->text('created_by_id')->nullable();
            $table->text('modified_by')->nullable();
            $table->text('modified_by_id')->nullable();
            $table->boolean('is_process_to_mainstream')->nullable();
            $table->text('gender')->nullable();
            $table->text('district')->nullable();
            $table->text('region')->nullable();
            $table->text('bill_number')->nullable();
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
        Schema::dropIfExists('lrd_pending_applications');
    }
}
