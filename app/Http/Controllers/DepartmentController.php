<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    public function index(){
        $departments = Department::all();
        return response()->json(["message" => "OK", "data" => $departments], 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:departments,name',
            'short_name' =>  'required|string|unique:departments,short_name'
        ]);
        if($validator->fails()){
            return response()->json(['message' => "Invalid data", 'data' => $validator->errors()->all()], 400);
        } else {
            $department = new Department();
            $department->name = trim(\request('name'));
            $department->short_name = trim(\request('short_name'));
            $department->save();

            return response()->json(["message" => "Department successfully created", "data" => $department], 201);
        }
    }
}
