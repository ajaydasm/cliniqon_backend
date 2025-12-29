<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([ 'success' => false, 'message' => $validator->errors() ], 422);
            }

            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json([ 'success' => false, 'message' => 'Invalid credentials'  ], 401);
            }
            $user = Auth::user();

            $user->tokens->each(function ($token) {
                $token->delete();
            });
            $token = $user->createToken('api-token')->accessToken;

            return response()->json([
                'message' => 'Login successful',
                'success' => true,
                'data' => [
                    'token' => $token,
                    'user' => $user
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([ 'success' => false, 'message' => $e->getMessage() ], 500);
        }

    }

    public function logout(Request $request)
    {
        try {
            $request->user()->token()->revoke();

            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
