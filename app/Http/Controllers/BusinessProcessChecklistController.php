<?php

namespace App\Http\Controllers;

use App\BusinessProcessChecklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BusinessProcessChecklistController extends Controller
{
    public function index(){
        if(\request('business_sub_process_id')){
            $businessProcessChecklists = BusinessProcessChecklist::where('business_sub_process_id', '=', \request('business_sub_process_id'))->get();
        } else {
            $businessProcessChecklists = BusinessProcessChecklist::all();
        }

        return response()->json(['message' => "", 'data' => $businessProcessChecklists], 200);
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
            try {
                $businessProcessChecklist = new BusinessProcessChecklist();
                $businessProcessChecklist->name = \request('name');
                $businessProcessChecklist->option = \request('option') ? \request('option') : false;
                $businessProcessChecklist->business_process_id = \request('businessProcessId');
                $businessProcessChecklist->business_sub_process_id = \request('businessSubProcessId');
                $businessProcessChecklist->priority = \request('priority');
                $businessProcessChecklist->save();

                return response()->json(['message' => 'Business process fee successfully created', 'data' => $businessProcessChecklist], 201);
            } catch (\Exception $e){
                Log::error($e);
                return response()->json(['message' => 'Error while creating business process fee', 'data' => $e], 500);
            }

        }

    }


    public function show($id){
        try{
            $businessProcessChecklist = BusinessProcessChecklist::findOrFail($id);
            return response()->json(['message' => "", 'data' => $businessProcessChecklist], 200);
        } catch (\Exception $e){
            Log::warning($e);
            return response()->json(['message' => 'Invalid id', 'data' => $e], 400);
        }

    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'option' => 'boolean',
            'businessProcessId' => 'required|integer|exists:business_processes,id',
            'businessSubProcessId' => 'required|integer|exists:business_sub_processes,id',
            'priority' => 'integer'
        ]);
        if($validator->fails()){
            return response()->json(['message' => "Invalid data", 'data' => $validator->errors()->all()], 400);
        }
        try{
            $businessProcessChecklist = BusinessProcessChecklist::findOrFail($id);
        } catch (\Exception $e){
            Log::warning($e);
            return response()->json(['message' => 'Invalid id', 'data' => $e], 400);
        }

        try {
            $businessProcessChecklist->name = \request('name');
            $businessProcessChecklist->option = \request('option');
            $businessProcessChecklist->business_process_id = \request('businessProcessId');
            $businessProcessChecklist->business_sub_process_id = \request('businessSubProcessId');
            $businessProcessChecklist->priority = \request('priority');
            $businessProcessChecklist->save();

            return response()->json(['message' => 'Business process checklist successfully updated', 'data' => $businessProcessChecklist], 200);
        } catch (\Exception $e){
            Log::error($e);
            return response()->json(['message' => 'Error while updating business process checklist', 'data' => $e], 500);
        }


    }
//fixme: look into catching different exceptions to make code compact
    public function destroy($id){
        try{
            $businessProcessChecklist = BusinessProcessChecklist::findOrFail($id);
        } catch (\Exception $e){
            Log::warning($e);
            return response()->json(['message' => 'Invalid id', 'data' => $e], 400);
        }
        try{
            $businessProcessChecklist->delete();
            return response()->json(['message' => 'Business process checklist successfully deleted', 'data' => []], 204);
        } catch (\Exception $e){
            Log::warning($e);
            return response()->json(['message' => 'Error while deleting business process checklist', 'data' => $e], 500);
        }
    }
}
