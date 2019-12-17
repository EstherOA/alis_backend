<?php

namespace App\Http\Controllers;

use App\BusinessProcessFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BusinessProcessFeeController extends Controller
{
    public function index(){
        if(\request('business_sub_process_id')){
            $businessProcessFees = BusinessProcessFee::where('business_sub_process_id', '=', \request('business_sub_process_id'))->get();
        } else {
            $businessProcessFees = BusinessProcessFee::all();
        }

        return response()->json(['message' => "", 'data' => $businessProcessFees], 200);
    }

    public function getByProcess(){
        if(\request('business_sub_process_id') == ""
            || \request('business_sub_process_id') == null
            || \request('business_process_id') == null)
            return response()->json(['message' => "Bad Request", 'data' => []], 400);
        $businessProcessFees = BusinessProcessFee::where('business_sub_process_id', '=', \request('business_sub_process_id'))
            ->where('business_process_id', '=', \request('business_process_id'))
            ->get();
        return response()->json(['message' => 'OK', 'data' => $businessProcessFees], 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'string',
            'businessProcessId' => 'required|integer|exists:business_processes,id',
            'businessSubProcessId' => 'required|integer|exists:business_sub_processes,id',
            'amount' => 'required|numeric',
            'category' => 'string'
        ]);
        if($validator->fails()){
            return response()->json(['message' => "Invalid data", 'data' => $validator->errors()->all()], 400);
        } else {
            try {
                $businessProcessFee = new BusinessProcessFee();
                $businessProcessFee->name = \request('name');
                $businessProcessFee->description = \request('description');
                $businessProcessFee->business_process_id = \request('businessProcessId');
                $businessProcessFee->business_sub_process_id = \request('businessSubProcessId');
                $businessProcessFee->amount = \request('amount');
                $businessProcessFee->category = \request('category');
                $businessProcessFee->save();

                return response()->json(['message' => 'Business process fee successfully created', 'data' => $businessProcessFee], 201);
            } catch (\Exception $e){
                Log::error($e);
                return response()->json(['message' => 'Error while creating business process fee', 'data' => $e], 500);
            }

        }

    }


    public function show($id){
        try{
            $businessProcessFee = BusinessProcessFee::findOrFail($id);
            return response()->json(['message' => "", 'data' => $businessProcessFee], 200);
        } catch (\Exception $e){
            Log::warning($e);
            return response()->json(['message' => 'Invalid id', 'data' => $e], 400);
        }

    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'string',
            'businessProcessId' => 'required|integer|exists:business_processes,id',
            'businessSubProcessId' => 'required|integer|exists:business_sub_processes,id',
            'amount' => 'required|numeric',
            'category' => 'string'
        ]);
        if($validator->fails()){
            return response()->json(['message' => "Invalid data", 'data' => $validator->errors()->all()], 400);
        }
        try{
            $businessProcessFee = BusinessProcessFee::findOrFail($id);
        } catch (\Exception $e){
            Log::warning($e);
            return response()->json(['message' => 'Invalid id', 'data' => $e], 400);
        }

        try {
            $businessProcessFee->name = \request('name');
            $businessProcessFee->description = \request('description');
            $businessProcessFee->business_process_id = \request('businessProcessId');
            $businessProcessFee->business_sub_process_id = \request('businessSubProcessId');
            $businessProcessFee->amount = \request('amount');
            $businessProcessFee->category = \request('category');
            $businessProcessFee->save();

            return response()->json(['message' => 'Business process fee successfully updated', 'data' => $businessProcessFee], 200);
        } catch (\Exception $e){
            Log::error($e);
            return response()->json(['message' => 'Error while updating business process fee', 'data' => $e], 500);
        }


    }
//fixme: look into catching different exceptions to make code compact
    public function destroy($id){
        try{
            $businessProcessFee = BusinessProcessFee::findOrFail($id);
        } catch (\Exception $e){
            Log::warning($e);
            return response()->json(['message' => 'Invalid id', 'data' => $e], 400);
        }
        try{
            $businessProcessFee->delete();
            return response()->json(['message' => 'Business process fee successfully deleted', 'data' => []], 204);
        } catch (\Exception $e){
            Log::warning($e);
            return response()->json(['message' => 'Error while deleting business process fee', 'data' => $e], 500);
        }
    }
}
