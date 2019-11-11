<?php

namespace App\Http\Controllers;

use App\Department;
use App\Document;
use App\DocumentTransaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
    public function index(){
        $documents = Document::all();
        return response()->json(['message' => 'OK', 'data' => $documents], 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string', //fixme: think of whether it will be necessary to make the file name unique
            'department' => 'required',
            'case_number' => 'required',//fixme: improve on validation
            'file' => 'required|file'
        ]);
        if($validator->fails()){
            return response()->json(['message' => "Invalid data", 'data' => $validator->errors()->all()], 400);
        } else {
            try {
                $document = DB::transaction(function () use($request) {
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
                    $document_history = new DocumentTransaction();
                    $document_history->file_id = $document->id;
                    $document_history->from_id = 0;
                    $document_history->from_name = "Upload";
                    $document_history->to_id = 1; //fixme: current authenticated user
                    $document_history->to_name = "David Marfo";
                    $document_history->from_remarks = "Upload of files"; //
                    $document_history->to_remarks = "Upload of files received";
                    $document_history->department_from = "Upload";
                    $document_history->department_to = "Upload"; //fixme: current authenticated user's department
                    $document_history->department_from_id = 0;
                    $document_history->department_to = 1; //fixme: current authenticated user's department
                    $document_history->save();

                   return $document;
                });
                return response()->json(['message' => "Upload successful", 'data' => $document], 201);

            } catch (\Exception $e){
                Log::error($e);
                return response()->json(['message' => 'Error while uploading file', 'data' => $e], 500);
            }
        }

    }

    public function transfer(Request $request, $id){ // move a file from one location to another
        $validator = Validator::make($request->all(), [
            'remarks' => 'required|string',
            'department_to' => 'required|exists:departments,id',
            'recipient' => 'required|exists:users,id',//fixme: improve on validation
        ]);
        if($validator->fails()){
            return response()->json(['message' => "Invalid data", 'data' => $validator->errors()->all()], 400);
        } else {
            try {
                $document = DB::transaction(function () use($id) {
                    $document = Document::findOrFail($id);
                    $document->department = Department::find(\request('department_to'))->name;
                    $document->save();
                    $document_history = new DocumentTransaction();
                    $document_history->file_id = $document->id;
                    $document_history->from_id = 1; //fixme: current authenticated user
                    $document_history->from_name = "David Marfo"; //fixme: current authenticated user
                    $document_history->to_id = \request('recipient'); //fixme: current authenticated user
                    $user = User::find(\request('recipient'));
                    $document_history->to_name = $user->first_name . " " . $user->last_name;
                    $document_history->from_remarks = \request('remarks'); //
                    $document_history->to_remarks = "Upload of files received from " . $user->first_name . " " . $user->last_name;
                    $document_history->department_from = "Upload";
                    $document_history->department_to = "Upload"; //fixme: current authenticated user's department
                    $document_history->department_from_id = 0;
                    $document_history->department_to = 1; //fixme: current authenticated user's department
                    $document_history->save();
                    return $document;
                });
                return response()->json(['message' => "File transfer successful", 'data' => $document], 200);

            } catch (\Exception $e) {
                Log::error($e);
                return response()->json(['message' => 'File not found', 'data' => $e], 404);
            }
        }
    }
}
