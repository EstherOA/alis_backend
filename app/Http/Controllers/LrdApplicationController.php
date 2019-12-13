<?php

namespace App\Http\Controllers;

use App\Document;
use App\LrdApplication;
use App\LrdMainApplication;
use App\LrdPendingApplication;
use App\PaymentBill;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LrdApplicationController extends Controller
{
    public function index($case_number){
        try {
            $case = LrdMainApplication::where('case_number', '=', $case_number)->count();
            if(!$case){
                return response()->json(['message' => 'Invalid case', 'data' => []], 400);
            }
            $caseJobs = LrdApplication::getAllJobsByCase($case_number);
            return response()->json(['message' => 'OK', 'data' => $caseJobs], 200);
        } catch (\Exception $e){
            return response()->json(['message' => 'Internal Server Error', 'data' => $e], 500);
        }

    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'businessProcessId' => 'required|integer|exists:business_processes,id',
            'businessSubProcessId' => 'required|integer|exists:business_sub_processes,id',
            'amountPaid' => 'required',
            'address' => 'required',
            'bankName' => 'required',
            'bankBranch' => 'required',
            'paymentMode' => 'required',
            'paymentSlipNumber' => 'required',
            'accountNumber' => 'required',
            'jobNumber' => 'required|exists:lrd_pending_applications,job_number',
            'remarks' => "required"
        ]);
        if($validator->fails()){
            return response()->json(['message' => "Invalid data", 'data' => $validator->errors()->all()], 400);
        } else {
            try {
                $pendingApplication = LrdPendingApplication::where('job_number', '=', \request('jobNumber'))->first();
                $id = DB::transaction(function () use($pendingApplication) {
                    $bill = PaymentBill::findOrFail($pendingApplication->bill_number);
                    $bill->payment_date = Carbon::today()->toDateTimeString();
                    $bill->payment_bank = \request('bankName');
                    $bill->payment_amount = \request('amountPaid');
                    $bill->payment_bank_branch = \request('bankBranch');
                    $bill->account_number = \request('accountNumber');
                    $bill->payment_slip_number = \request('paymentSlipNumber');
                    $bill->payment_remarks = \request('remarks');
                    $bill->payment_mode = \request('paymentMode');
                    $bill->save();
                    $application = new LrdApplication();
                    $application->job_number = \request('jobNumber');
                    $application->business_process_sub_id = \request('businessSubProcessId');
                    $application->business_process_sub_name = $pendingApplication->business_process_sub_name;
                    $application->business_process_id = \request('businessProcessId');
                    $application->business_process_name =  $pendingApplication->business_process_name;
                    $application->created_by = "David Marfo";
                    $application->created_by_id = 1; //fixme: change to authenticated user id
                    $application->case_number = "LCGARGACN76102019";
                    $application->save();
                    $application->case_number =  'LCGARGACN'.sprintf("%05d", $application->id).Carbon::today()->format('Y');
                    $application->save();
                    $main_application = new LrdMainApplication();
                    $main_application->ar_name = \request('name');
                    $main_application->ar_address = \request('address');
                    $main_application->case_number = $application->case_number;
                    $main_application->locality = "Abehenease";
                    $main_application->nature_of_instrument = "ASSIGNMENT";
                    $main_application->created_by = "David Marfo";
                    $main_application->created_by_id = 1; //fixme: change to authenticated user id
                    $main_application->save();
                    $pendingApplication->status = "completed";
                    $pendingApplication->save();
                    return $main_application->id;
                });
                return response()->json(['message' => 'Business process fee successfully created', 'data' => ["url" => url('generate-pdf/acknowledgement/'.$id)]], 201);
            } catch (\Exception $e){
            Log::error($e);
                return response()->json(['message' => 'Error while creating case', 'data' => $e], 500);
            }
        }

    }


}
