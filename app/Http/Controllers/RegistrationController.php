<?php

namespace App\Http\Controllers;

use App\Notifications\activateEmail;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{

    public function store(Request $request) {

        $validator = Validator::make($request->all(), [
           'first_name' => 'required|string',
           "last_name" => "required|string",
           "email" => "required|email",
           "phone_number" => "required|digits:10",
           "password" => "required|string"
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
            $newUser->password = bcrypt($request['password']);
            $newUser->phone_number = $request['phone_number'];
            $newUser->role_id = 1;
            $newUser->save();

            //create token
            $token = $newUser->createToken('alis')->accessToken;

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
        try{

            $user = User::where('activation_token', '=', $token);

//            logger()->debug($user->first());
            if (!$user->count()) {
                return response()->json([
                    'message' => 'Invalid activation token',
                    'body' => ''
                ], 404);
            }
            $user = $user->first();
            $user->email_verified_at = Carbon::now();
            $user->save();
            return response()->json([
                'message' => 'Email verified successfully',
                'body' => $user
            ], 200 );
        }catch(\Exception $e) {

            return response()->json([
                'message' => 'Email verification failed',
                'body' => $e->getMessage()
            ], 500);
        }
    }

}
