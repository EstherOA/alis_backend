<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SessionsController extends Controller
{
    //

    public function login(Request $request) {

        $validator = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required"
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => 'Invalid details',
                'body' => $validator->errors()->all()
            ], 400);
        }
        try {

            if(Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {

                return response()->json([
                    'message' => 'Error while authenticating user',
                    'body' => Auth::user()
                ], 200);
            }

            return response()->json([
                'message' => 'User authentication failed',
                'body' => []
            ], 400);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error while authenticating user',
                'body' => $e->getMessage()
            ], 500);
        }

    }

    public function logout(Request $request) {

        try {
            $request->user()->token()->revoke();

            return response()->json([
                'message' => 'User logged out successfully',
                'body' => []
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error while logging out',
                'body' => $e->getMessage()
            ], 500);
        }
    }
}
