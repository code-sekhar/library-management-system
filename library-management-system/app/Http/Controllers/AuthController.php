<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //Register API
//    public function __construct()
//    {
//        $this->middleware('auth:api', ['except' => ['login', 'register','logout']]);
//    }
    public function register(Request $request)
    {


          try{
              $validatedData = $request->validate([
                  'name' => 'required|max:255',
                  'username'=>'required|max:255|unique:users',
                  'email' => 'required|email|max:255|unique:users',
                  'role'=>'required',
                  'password' => 'required|min:6',
              ]);

              $user = User::create([
                  'name'=> $validatedData['name'],
                  'username'=> $validatedData['username'],
                  'email'=> $validatedData['email'],
                  'role'=> $validatedData['role'],
                  'password' => Hash::make($validatedData['password']),
              ]);
              return response()->json([
                  'success'=>true,
                  'data'=>$user,
                  'message'=>'User created successfully',
                  'status'=>200
              ],200);
          }catch (\Exception $e){
              return response()->json(['error'=>'Unauthorized'], 401);
          }

    }
    public function login(Request $request){
        try{
            $request->validate([
                'email'=>'required|email',
                'password'=>'required'
            ]);
            $user = User::where('email',$request->email)->first();
            if(! $user || ! Hash::check($request->password, $user->password)){
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);

            }
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'success'=>true,
                'token'=>$token,
                'message'=>'Login successfully',
            ],200);
        }catch (\Exception $e){
            return response()->json(['error'=>'Unauthorized'], 401);
        }
    }
    public function logout(Request $request){
        try{
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'success'=>true,
                'message'=>'Logout successfully',
                'status'=>200
            ],200);
        }catch (\Exception $e){
            return response()->json(['error'=>'Unauthorized'], 401);
        }
    }
}
