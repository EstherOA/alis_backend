<?php

namespace App\Http\Controllers;

use App\Notifications\activateEmail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    //

    public function store(Request $request) {

        $validator = Validator::make($request->all(), [
           "first_name" => "required|string",
           "last_name" => "required|string",
           "email" => "required|email",
           "phone_number" => "required|digits:10",
           "password" => "required|confirmed"
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => 'Invalid details',
                'body' => $validator->errors()->all()
            ], 400);
        }
        try{
            $newUser = new User();
            $newUser->first_name = $request['first_name'];
            $newUser->last_name = $request['last_name'];
            $newUser->email = $request['email'];
            $newUser->password = bcrypt($request['first_name']);
            $newUser->phone_number = $request['phone_number'];
            $newUser->save();

            //create token
            $token = $newUser->createToken('payvm')->accessToken;

            //verify email
            $newUser->notify(new activateEmail($newUser));

            return response()->json([
                'message' => 'User created successfully',
                'body' => $newUser,
                'token' => $token
            ], 201);

        }catch (\Exception $e) {

            logger()->error($e->getMessage());
            return response()->json([
                'message' => 'Error while creating user',
                'body' => $e->getMessage()
            ], 500);
        }
    }

    public function emailVerification($token)
    {
        $existingToken = DB::table('tokens')->where('token', '=', $token)->first();
        if (!$existingToken) {
            return response()->json([
                'message' => 'Invalid activation token'
            ], 404);
        }

        $user = User::where('id', '=', $existingToken->user_id)->first();

        $user->is_active = true;
        $user->save();
        return response()->json([

        ]);
    }

}
