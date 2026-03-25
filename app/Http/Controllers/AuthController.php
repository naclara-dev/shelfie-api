<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Authenticates the user and provides an access token.
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */    
    public function login(Request $request) {
        # Basic validation
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        # Gets the user with given email
        $user = User::where('email', $request->email)->first();

        # Validates the password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials.'
            ], 401);
        }

        # Deletes old tokens for this user
        $user->tokens()->delete();

        # Creates a new access token
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user'  => $user,
            'token' => $token
        ]);
    }

    /**
     * Deletes the current access token.
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */   
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }
}
