<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LrdPendingApplication extends Model
{
    public static function getAllPendingApplications(){
       return  DB::table('lrd_pending_applications')
            ->join('payment_bills', 'lrd_pending_applications.bill_number', '=', 'payment_bills.id')
            ->select('lrd_pending_applications.job_number', 'lrd_pending_applications.business_process_name',
                'lrd_pending_applications.business_process_sub_name', 'lrd_pending_applications.business_process_id',
                'lrd_pending_applications.business_process_sub_id', 'payment_bills.bill_amount', 'payment_bills.customer_name',
               'lrd_pending_applications.id' )
           ->where('lrd_pending_applications.status', '=', 'pending')
            ->get();
}
}
