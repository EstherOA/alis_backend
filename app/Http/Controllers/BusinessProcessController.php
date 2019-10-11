<?php

namespace App\Http\Controllers;

use App\BusinessProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BusinessProcessController extends Controller
{
    public function index(){
       $businessProcesses = BusinessProcess::all();
        return response()->json(['message' => "OK", 'data' => $businessProcesses], 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'priority' => 'required|integer',
            'division' => 'required',
            'registrationRelated' => 'string',
            'accountNumber' => 'string'
            ]);
        if($validator->fails()){
            return response()->json(['message' => "Invalid data", 'data' => $validator->errors()->all()], 400);
        } else {
            try {
                $businessProcess = new BusinessProcess;
                $businessProcess->name = \request('name');
                $businessProcess->priority = \request('priority');
                $businessProcess->division = \request('division');
                $businessProcess->registration_related = \request('registrationRelated');
                $businessProcess->account_number = \request('accountNumber');
                $businessProcess->save();

                return response()->json(['message' => 'Business Process successfully created', 'data' => $businessProcess], 201);
            } catch (\Exception $e){
                Log::error($e);
                return response()->json(['message' => 'Error while creating business process', 'data' => $e], 500);
            }

        }

    }


    public function show($id){
        try{
            $businessProcess = BusinessProcess::findOrFail($id);
            return response()->json(['message' => "", 'data' => $businessProcess], 200);
        } catch (\Exception $e){
            Log::warning($e);
            return response()->json(['message' => 'Invalid id', 'data' => $e], 400);
        }

    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'priority' => 'required|integer',
            'division' => 'required',
            'registrationRelated' => 'string',
            'accountNumber' => 'string'
        ]);
        if($validator->fails()){
            return response()->json(['message' => "Invalid data", 'data' => $validator->errors()->all()], 400);
        }
        try{
            $businessProcess = BusinessProcess::findOrFail($id);
        } catch (\Exception $e){
            Log::warning($e);
            return response()->json(['message' => 'Invalid id', 'data' => $e], 400);
        }

        try {
            $businessProcess->name = \request('name');
            $businessProcess->priority = \request('priority');
            $businessProcess->division = \request('division');
            $businessProcess->registration_related = \request('registrationRelated');
            $businessProcess->account_number = \request('accountNumber');
            $businessProcess->save();

            return response()->json(['message' => 'Business Process successfully updated', 'data' => $businessProcess], 200);
        } catch (\Exception $e){
            Log::error($e);
            return response()->json(['message' => 'Error while updating business process', 'data' => $e], 500);
        }


    }
//fixme: look into catching different exceptions to make code compact
    public function destroy($id){
        try{
            $businessProcess = BusinessProcess::findOrFail($id);
        } catch (\Exception $e){
            Log::warning($e);
            return response()->json(['message' => 'Invalid id', 'data' => $e], 400);
        }
        try{
            $businessProcess->delete();
            return response()->json(['message' => 'Business process successfully deleted', 'data' => []], 204);
        } catch (\Exception $e){
            Log::warning($e);
            return response()->json(['message' => 'Error while deleting business process', 'data' => $e], 500);
        }
    }
}
