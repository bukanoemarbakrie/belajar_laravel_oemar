<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email'    => 'email|required',
                'password' => 'min:8|required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Validation Error',
                    'errors'  => $validator->errors()
                ], 422);
            }

            $credentials = $request->only('email', 'password');

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Invalid Credentials'
                ], 401);
            }

            $user = Auth::user();
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'status'  => true,
                'message' => 'Login success',
                'token'   => $token,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function me(Request $request)
    {
        return response()->json([
            'status' => true,
            'user'   => $request->user(),
        ]);
    }
}
