<?php

namespace App\Http\Controllers;

use App\PaymentBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentBillController extends Controller
{
    public function index(){
        if(\request('job_number')){
            $bills = PaymentBill::where('job_number', '=', \request('job_number'))->get();
        } else {
            $bills = PaymentBill::all();
        }
        return response()->json(['message' => "", 'data' => $bills], 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'option' => 'boolean',
            'businessProcessId' => 'required|integer|exists:business_processes,id',
            'businessSubProcessId' => 'required|integer|exists:business_sub_processes,id',
            'priority' => 'integer'
        ]);
        if($validator->fails()){
            return response()->json(['message' => "Invalid data", 'data' => $validator->errors()->all()], 400);
        } else {

        }

    }
}
