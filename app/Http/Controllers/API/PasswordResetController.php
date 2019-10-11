<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\User;
use App\PasswordReset;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    /**
     * Create token password reset
     *
     * @param  [string] email
     * @return [string] message
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => 'Invalid email',
                'body' => []
            ], 404);
        }
        try {
            $user = User::where('email', $request['email'])->first();
            if (!$user)
                return response()->json([
                    'message' => "Invalid email"
                ], 404);

            $passwordReset = PasswordReset::updateOrCreate(
                ['email' => $user->email],
                [
                    'email' => $user->email,
                    'token' => Str::random(60)
                ]
            );
            if ($user && $passwordReset)
                $user->notify(
                    new PasswordResetRequest($passwordReset->token)
                );
            return response()->json([
                'message' => 'Password reset link sent'
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error while reseting password',
                'body' => $e->getMessage()
            ], 500);
        }

    }
    /**
     * Find token password reset
     *
     * @param  [string] $token
     * @return [string] message
     * @return [json] passwordReset object
     */
    public function find($token)
    {
        $passwordReset = PasswordReset::where('token', $token)
            ->first();
        if (!$passwordReset)
            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 404);
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 400);
        }
        return response()->json([
            'message' => 'Password reset token found',
            '$token' => $passwordReset
        ], 200);
    }
     /**
     * Reset password
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @param  [string] token
     * @return [string] message
     * @return [json] user object
     */
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed',
            'token' => 'required|string'
        ]);
        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();
        if (!$passwordReset)
            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 404);
        $user = User::where('email', $passwordReset->email)->first();
        if (!$user)
            return response()->json([
                'message' => "We can't find a user with that e-mail address."
            ], 404);
        $user->password = bcrypt($request['password']);
        $user->save();
        $passwordReset->delete();
        $user->notify(new PasswordResetSuccess($passwordReset));
        return response()->json($user);
    }
}