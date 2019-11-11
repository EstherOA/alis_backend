<?php

namespace App\Http\Controllers;

use App\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
    public function index(){
        $documents = Document::all();
        return response()->json(['message' => 'OK', 'data' => $documents], 200);
    }

    public function store(Request $request){
        Log::info($request);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'department' => 'required',
            'case_number' => 'required',//fixme: improve on validation
            'file' => 'required|file'
        ]);
        if($validator->fails()){
            return response()->json(['message' => "Invalid data", 'data' => $validator->errors()->all()], 400);
        } else {
            try {
                $path = $request->file('file')->store('uploads');
                $pieces = explode(".", $path);

                $document = new Document();
                $document->file_type = $pieces[1];
                $document->file_name = \request('name');
                $document->file_path = $path;
                $document->department = \request('department');
                $document->created_by = "David Marfo"; //fixme: use authenticated user
                $document->created_by_id = 1; //fixme: use authenticated user
                $document->case_number = \request('case_number');
                $document->save();
                //add documents transactions
                return response()->json(['message' => "Upload successful", 'data' => $document], 201);

            } catch (\Exception $e){
                Log::error($e);
                return response()->json(['message' => 'Error while uploading file', 'data' => $e], 500);
            }
        }

    }
}
