<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLrdApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lrd_applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('case_number')->nullable();
            $table->text('job_number')->nullable();
            $table->integer('business_process_sub_id')->nullable();
            $table->string('business_process_sub_name',255)->nullable();
            $table->integer('business_process_id')->nullable();
            $table->string('business_process_name',255)->nullable();
            $table->text('job_purpose')->nullable();
            $table->enum('job_status', ['pending', 'completed'])->default('pending');
            $table->timestamp('job_datesend')->nullable();
            $table->text('job_received_by')->nullable();
            $table->text('job_forwarded_by')->nullable();
            $table->text('job_received_by_id')->nullable();
            $table->text('job_forwarded_by_id')->nullable();
            $table->text('current_division_of_application')->nullable();
            $table->text('current_application_status')->nullable();
            $table->integer('smd_licensed_surveyor_uid')->nullable();
            $table->text('smd_licensed_surveyor_number')->nullable();
            $table->text('smd_licensed_surveyor_name')->nullable();
            $table->text('smd_regional_number')->nullable();
            $table->text('smd_lessees_name')->nullable();
            $table->text('smd_locality')->nullable();
            $table->text('smd_district')->nullable();
            $table->text('smd_region')->nullable();
            $table->text('comment')->nullable();
            $table->boolean('is_filed')->nullable();
            $table->text('filed_number')->nullable();
            $table->text('filed_by_id')->nullable();
            $table->text('filed_by_name')->nullable();
            $table->timestamp('file_date')->nullable();
            $table->boolean('is_completed')->nullable();
            $table->timestamp('completed_date')->nullable();
            $table->text('completed_by_id')->nullable();
            $table->text('completed_by_name')->nullable();
            $table->boolean('is_collected')->nullable();
            $table->text('collected_by')->nullable();
            $table->text('collected_by_id_type')->nullable();
            $table->text('collected_by_id_number')->nullable();
            $table->timestamp('collected_date')->nullable();
            $table->text('collection_issued_by_id')->nullable();
            $table->text('collection_issued_by_name')->nullable();
            $table->text('created_by')->nullable();
            $table->text('created_by_id')->nullable();
            $table->text('modified_by')->nullable();
            $table->text('modified_by_id')->nullable();
            $table->integer('record_inbox_status')->nullable();
            $table->boolean('is_batched')->nullable();
            $table->boolean('is_ready_for_batch')->nullable();
            $table->text('batch_number')->nullable();
            $table->timestamp('batch_date')->nullable();
            $table->text('batched_by')->nullable();
            $table->text('batched_by_id')->nullable();
            $table->text('divisional_registry_unit')->nullable();
            $table->text('old_file_record_numbers')->nullable();
            $table->integer('application_priority_number')->nullable();
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
        Schema::dropIfExists('lrd_applications');
    }
}
