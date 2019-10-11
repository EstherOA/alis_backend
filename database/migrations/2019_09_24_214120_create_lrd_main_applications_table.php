<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLrdMainApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lrd_main_applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('ar_client_id')->nullable();
            $table->text('ar_name')->nullable();
            $table->integer('pid')->nullable();
            $table->string('glpin',15)->nullable();
            $table->string('case_number',250)->nullable();
            $table->text('licensed_surveyor_number')->nullable();
            $table->string('regional_number',250)->nullable();
            $table->string('locality',250)->nullable();
            $table->string('district',250)->nullable();
            $table->string('region',250)->nullable();
            $table->string('size_of_land',50)->nullable();
            $table->timestamp('date_of_document')->nullable();
            $table->string('nature_of_instrument',50)->nullable();
            $table->text('certificate_number')->nullable();
            $table->text('extent')->nullable();
            $table->string('registry_mapref',250)->nullable();
            $table->string('type_of_interest',250)->nullable();
            $table->text('type_of_use')->nullable();
            $table->string('volume_number',50)->nullable();
            $table->string('folio_number',50)->nullable();
            $table->string('term',50)->nullable();
            $table->timestamp('commencement_date')->nullable();
            $table->integer('renewal_term')->nullable();
            $table->text('consideration_fee')->nullable();
            $table->decimal('stamp_duty_payable',10,2)->nullable();
            $table->decimal('assessed_value',10,2)->nullable();
            $table->text('parcel_description')->nullable();
            $table->text('plot_number')->nullable();
            $table->timestamp('publicity_date')->nullable();
            $table->text('plan_no')->nullable();
            $table->text('cc_no')->nullable();
            $table->text('ltr_plan_no')->nullable();
            $table->text('family_of_grantor')->nullable();
            $table->text('locality_class')->nullable();
            $table->integer('rent_review_period')->nullable();
            $table->decimal('annual_rent',10,2)->nullable();
            $table->text('rent_period_covered')->nullable();
            $table->timestamp('rent_review_date')->nullable();
            $table->timestamp('date_of_first_payment')->nullable();
            $table->decimal('outstanding_rent',10,2)->nullable();
            $table->text('remark_or_comment')->nullable();
            $table->timestamp('date_of_registration')->nullable();
            $table->string('case_status',250)->nullable();
            $table->text('created_by');
            $table->text('created_by_id');
            $table->text('modified_by')->nullable();
            $table->text('modified_by_id')->nullable();
            $table->string('stool_family_name',500)->nullable();
            $table->string('is_part_of_gelis_area',10)->nullable();
            $table->string('ar_address',2000)->nullable();
            $table->string('grantors_name',2000)->nullable();
            $table->string('grantors_address',500)->nullable();
            $table->text('stamp_duty_description')->nullable();
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
        Schema::dropIfExists('lrd_main_applications');
    }
}
