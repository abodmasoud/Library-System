<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd('jjj');
        $categories = Category::latest('id')->paginate(10);
        return response()->json([
            "success" => true,
            'data' => $categories
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
            'name' => 'required|min:2|max:100',
        ]);

        $categories = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);


        return response()->json([
            'message' => 'Registration Successfull',
            'data' => $categories
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
    public function update(Request $request, $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:100',
        ]);
        // $getCategories = Category::get()->where();

        Category::updateOrCreate(
            [
                'id' => $category
            ],
            [
                'name' => $request->name,
                'slug' => Str::slug($request->name)
            ]
        );
        $category = Category::find($category);

        return response()->json([
            'message' => 'Updated Successfull',
            'data' => $category
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($category)
    {
        // dd($category);
        Category::destroy($category);
        return response()->json([
            'message' => 'deleted Successfull',
            'data' => $category
        ], 200);
    }
}