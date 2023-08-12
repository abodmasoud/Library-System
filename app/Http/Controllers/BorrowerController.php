<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class BorrowerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $borrowers = Borrower::latest('id')->paginate(10);
        return response()->json([
            "success" => true,
            'data' => $borrowers
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required|min:2|max:100',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|max:100',
            'confirm_password'=>'required|same:password'
        ]);

        $borrowers = Borrower::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password)
        ]);


        return response()->json([
            'message' => 'Registration Successfull',
            'data' => $borrowers
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $borrower)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required|min:2|max:100',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|max:100',
            'confirm_password'=>'required|same:password'
        ]);

        Borrower::updateOrCreate(
            [
                'id' => $borrower
            ],
            [
                'name' => $request->name,
                'email'=> $request->email,
                'password'=> Hash::make($request->password)
            ]
        );
        $borrower = Borrower::find($borrower);

        return response()->json([
            'message' => 'Updated Successfull',
            'data' => $borrower
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($borrower)
    {
        Borrower::destroy($borrower);
        return response()->json([
            'message' => 'deleted Successfull',
            'data' => $borrower
        ], 200);
    }
}
