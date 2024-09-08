<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    use ApiResponse;
    function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'No user found with this email'], 422);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Incorrect password'], 422);
        }

        $success['token'] =  $user->createToken('round56')->plainTextToken;
        $success['user'] =  $user;
        Auth::login($user);
        return response()->json(['data' => $success], 200);
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return $this->sendResponse('', 'User logged out successfully.');
    }
}
