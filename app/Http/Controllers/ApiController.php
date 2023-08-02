<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function login(Request $request)
    {
        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return response()->json([
                "success" => false,
                "status" => 200
            ]);
        }
        $user = auth()->user();
        $token = $user->createToken('token',['all:users']);

        return $token->plainTextToken;
    }

    public function register(Request $request)
    {
        // $request->validate([
        //     'name'=>'required|min:2|max:100',
        //     'email'=>'required|email|unique:users',
        //     'password'=>'required|min:6|max:100',
        //     'confirm_password'=>'required|same:password'
        // ]);

        $validator = Validator::make($request->all(), [
            'name'=>'required|min:2|max:100',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|max:100',
            'confirm_password'=>'required|same:password'
        ]);

        if($validator->fails()){
            return response()->json([
                'message'=>'Validations fails',
                'errors'=>$validator->errors()
            ],422);
        }

        $user = User::create([
           'name'=>$request->name,
           'email'=>$request->email,
           'password'=>Hash::make($request->password)
        ]);

        return response()->json([
            'message'=>'Registration Successfull',
            'data'=>$user
        ],200);

    }

    public function getUsers(Request $request)
    {

        $user = auth()->user();
        if($user->tokenCan('all:users')){
            $users = User::all();
             return response()->json([
                "success" => true,
                "data" => $users,
                "status" => 200
            ]);
        }

        return response()->json(["success" => false]);

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'User successfully logout',
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}