<?php

namespace App\Http\Controllers;

use App\BusinessProcessFee;
use App\LrdApplication;
use App\LrdMainApplication;
use App\LrdPendingApplication;
use App\PaymentBill;
use PDF;
use Illuminate\Http\Request;


class PDFController extends Controller
{
    //
    public function generatePDF($type, $id)
    {
        if($type === "service"){
            try{
                $pendingApplication = LrdPendingApplication::findOrFail($id);
                $bill = PaymentBill::findOrFail($pendingApplication->bill_number);
                $process_fees = BusinessProcessFee::where('business_sub_process_id', '=', $pendingApplication->business_process_sub_id)->get();
                return view('pdf.service_bill', compact('bill', 'pendingApplication', 'process_fees'));
            } catch (\Exception $e){
                abort(404);
            }

        }
        elseif($type === "acknowledgement"){
            try {
                $main_application = LrdMainApplication::findOrFail($id);
                $application = LrdApplication::where('case_number', '=', $main_application->case_number)->first();
                return view('pdf.acknowledgement_slip', compact('main_application', 'application'));
            } catch (\Exception $e){
                abort(404);
            }
        }

    }
}
