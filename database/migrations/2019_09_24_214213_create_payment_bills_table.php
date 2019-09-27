<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_bills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('customer_uid')->nullable();
            $table->string('customer_id',200)->nullable();
            $table->string('customer_name',500)->nullable();
            $table->string('job_number',200)->nullable();
            $table->integer('business_process_sub_id')->nullable();
            $table->string('business_process_name',500)->nullable();
            $table->timestamp('bill_date')->nullable();
            $table->decimal('bill_amount',10,2)->nullable();
            $table->string('category_identifier',150)->nullable();
            $table->string('type_of_revenue',150)->nullable();
            $table->string('revenue_group',150)->nullable();
            $table->string('division',150)->nullable();
            $table->text('created_by');
            $table->text('created_by_id');
            $table->string('payment_slip_number',50)->nullable();
            $table->string('payment_remarks',255)->nullable();
            $table->string('payment_mode',150)->nullable();
            $table->string('nature_of_instrument',500)->nullable();
            $table->string('bill_number',500)->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->decimal('payment_amount',10,2)->nullable();
            $table->string('payment_status',150)->nullable();
            $table->string('payment_bank',150)->nullable();
            $table->string('payment_bank_branch',150)->nullable();
            $table->integer('payment_confirmation_status')->nullable();
            $table->string('account_number',150)->nullable();
            $table->text('modified_by')->nullable();
            $table->text('modified_by_id')->nullable();
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
        Schema::dropIfExists('payment_bills');
    }
}
