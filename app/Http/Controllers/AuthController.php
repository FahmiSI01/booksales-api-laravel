<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request){
        //setup validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        //check validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        //cek keberhasilan
        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'User registered successfully',
                'data' => $user
            ], 201); 
        } 

        //cek gagal
        return response()->json([
            'success' => false,
            'message' => 'User creation failed',
        ], 409);

    }

    public function login(Request $request){
        //validator
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        //check validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //get kredensial dari request
        $credentials = $request->only('email', 'password');

        //cek isfailed
        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email or password is wrong',
            ], 401);
        }

        // cek success
        return response()->json([
            'success' => true,
            'message' => 'Login successfully',
            'user' => auth()->guard('api')->user(),
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request){
        try{
            JWTAuth::invalidate(JWTAuth::getToken());
            
            return response()->json([       
                'success' => true,
                'message' => 'Logout successfully',
            ], 200);        
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Logout failed',
            ], 500);
        }
    }
}
