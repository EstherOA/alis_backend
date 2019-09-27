<?php

namespace App\Http\Controllers;

use App\BusinessSubProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BusinessSubProcessController extends Controller
{
    public function index(){
        if(\request('business_process_id')){
            $businessSubProcesses = BusinessSubProcess::where('business_process_id', '=', \request('business_process_id'))->get();
        } else {
            $businessSubProcesses = BusinessSubProcess::all();
        }

        return response()->json(['message' => "", 'data' => $businessSubProcesses], 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'priority' => 'required|integer',
            'businessProcessId' => 'required|integer|exists:business_processes,id',
            'accountNumber' => 'string'
        ]);
        if($validator->fails()){
            return response()->json(['message' => "Invalid data", 'data' => $validator->errors()->all()], 400);
        } else {
            try {
                $businessSubProcess = new BusinessSubProcess();
                $businessSubProcess->name = \request('name');
                $businessSubProcess->priority = \request('priority');
                $businessSubProcess->business_process_id = \request('businessProcessId');
                $businessSubProcess->account_number = \request('accountNumber');
                $businessSubProcess->save();

                return response()->json(['message' => 'Business sub process successfully created', 'data' => $businessSubProcess], 201);
            } catch (\Exception $e){
                Log::error($e);
                return response()->json(['message' => 'Error while creating business sub process', 'data' => $e], 500);
            }

        }

    }


    public function show($id){
        try{
            $businessSubProcess = BusinessSubProcess::findOrFail($id);
            return response()->json(['message' => "", 'data' => $businessSubProcess], 200);
        } catch (\Exception $e){
            Log::warning($e);
            return response()->json(['message' => 'Invalid id', 'data' => $e], 400);
        }

    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'priority' => 'required|integer',
            'businessProcessId' => 'required|integer|exists:business_processes,id',
            'accountNumber' => 'string'
        ]);
        if($validator->fails()){
            return response()->json(['message' => "Invalid data", 'data' => $validator->errors()->all()], 400);
        }
        try{
            $businessSubProcess = BusinessSubProcess::findOrFail($id);
        } catch (\Exception $e){
            Log::warning($e);
            return response()->json(['message' => 'Invalid id', 'data' => $e], 400);
        }

        try {
            $businessSubProcess->name = \request('name');
            $businessSubProcess->priority = \request('priority');
            $businessSubProcess->business_process_id = \request('businessProcessId');
            $businessSubProcess->account_number = \request('accountNumber');
            $businessSubProcess->save();

            return response()->json(['message' => 'Business Sub Process successfully updated', 'data' => $businessSubProcess], 200);
        } catch (\Exception $e){
            Log::error($e);
            return response()->json(['message' => 'Error while updating business sub process', 'data' => $e], 500);
        }


    }
//fixme: look into catching different exceptions to make code compact
    public function destroy($id){
        try{
            $businessSubProcess = BusinessSubProcess::findOrFail($id);
        } catch (\Exception $e){
            Log::warning($e);
            return response()->json(['message' => 'Invalid id', 'data' => $e], 400);
        }
        try{
            $businessSubProcess->delete();
            return response()->json(['message' => 'Business sub process successfully deleted', 'data' => []], 204);
        } catch (\Exception $e){
            Log::warning($e);
            return response()->json(['message' => 'Error while deleting business sub process', 'data' => $e], 500);
        }
    }
}
