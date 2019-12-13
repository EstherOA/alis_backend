<?php

namespace App\Http\Controllers;

use App\BusinessProcess;
use App\BusinessProcessFee;
use App\BusinessSubProcess;
use App\LrdPendingApplication;
use App\PaymentBill;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LrdPendingApplicationController extends Controller
{

    public function index(){
        $pendingApplication = LrdPendingApplication::getAllPendingApplications();
        return response()->json(['message' => "OK", 'data' => $pendingApplication], 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'businessProcessId' => 'required|integer|exists:business_processes,id',
            'businessSubProcessId' => 'required|integer|exists:business_sub_processes,id',
            'amount' => 'required',
            'email' => 'email'
        ]);
        if($validator->fails()){
            return response()->json(['message' => "Invalid data", 'data' => $validator->errors()->all()], 400);
        } else {
            try {
                $id = DB::transaction(function () {
                    //generate job number

                    $bill = new PaymentBill();
                    $bill->customer_name = \request('name');
                    $bill->business_process_name = BusinessProcess::where('id', '=', \request('businessProcessId'))->first('name');
                    $bill->business_process_sub_id = \request('businessSubProcessId');
                    $bill->created_by = "David Marfo";
                    $bill->created_by_id = 1; //fixme: change to authenticated user id
                    $bill->bill_date = Carbon::today()->toDateString();
                    $bill->bill_amount = BusinessProcessFee::where('business_process_id', '=', \request('businessProcessId'))
                                            ->where('business_sub_process_id', '=', \request('businessSubProcessId'))->value('amount');
                    Log::info($bill->bill_amount);
                    $bill->save();
                    $bill->job_number =  'LVDGAST'.sprintf("%05d", $bill->id).Carbon::today()->format('Y');
                    $bill->save();
                    $pendingApplication = new LrdPendingApplication();
                    $pendingApplication->lessees_name = \request('name');
                    $pendingApplication->business_process_name = BusinessProcess::where('id', '=', \request('businessProcessId'))->value('name');
                    $pendingApplication->business_process_sub_name = BusinessSubProcess::where('id', '=', \request('businessSubProcessId'))->value('name');
                    $pendingApplication->business_process_id = \request('businessProcessId');
                    $pendingApplication->business_process_sub_id = \request('businessSubProcessId');
                    $pendingApplication->bill_number = $bill->id;
                    $pendingApplication->job_number = $bill->job_number;
                    $pendingApplication->email_address = \request('email');
                    $pendingApplication->created_by = "David Marfo";
                    $pendingApplication->created_by_id = 1; //fixme: change to authenticated user id
                    $pendingApplication->save();
                    return $pendingApplication->id;
                });
                return response()->json(['message' => 'Application successfully created', 'data' => ["url" => url('generate-pdf/service/'.$id)]], 201);
            } catch (\Exception $e){
                Log::error($e);
                return response()->json(['message' => 'Error while creating application', 'data' => $e], 500);
            }

        }
    }
}
