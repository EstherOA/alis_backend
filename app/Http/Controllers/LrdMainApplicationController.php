<?php

namespace App\Http\Controllers;

use App\Document;
use App\LrdMainApplication;
use Illuminate\Http\Request;

class LrdMainApplicationController extends Controller
{
    public function index(){
        $cases = LrdMainApplication::all();
        return response()->json(['message' => "OK", 'data' => $cases], 200);
    }

    public function show($case_number){
        try {
            $case = LrdMainApplication::where('case_number', '=', $case_number);
            if(!$case->count()){
                return response()->json(['message' => 'Invalid case', 'data' => []], 400);
            }

            return response()->json(['message' => 'OK', 'data' => $case->first()], 200);
        } catch (\Exception $e){
            return response()->json(['message' => 'Internal Server Error', 'data' => $e], 500);
        }
    }

    public function documents($case_number){
        try{
            $documents = Document::where('case_number', '=', $case_number)->get();
            return  response()->json(['message' => 'OK', 'data' => $documents], 200);
        } catch (\Exception $e){
            return response()->json(['message' => 'Internal Server Error', 'data' => $e], 500);
        }


    }

}
