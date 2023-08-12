<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrower;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{

    public function index(){
        $books = Book::latest('id')->paginate(10);
        return response()->json([
            "success" => true,
            'data'=>$books
        ],200);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name'=>'required|min:2|max:100',
            'author'=>'required|min:2|max:100',
            'image'=>'required|image|mimes:png,jpeg,jpg,svg',
            'status'=>'required|in:available,borrowed',
        ]);

        $ex = $request->file('image')->getClientOriginalExtension();
        $filename = Str::slug($request->name);
        $filename = $filename . '-' . date('d-m-Y') . '-' . time() . '.' . $ex;
        $path_image = $request->file('image')->storeAs('uploads/books', $filename);

        // dd($request->all());

        $books = Book::create([
            'name' => $request->name,
            'author' => $request->author,
            'slug' => Str::slug($request->name),
            'image' => $path_image,
            'status' => $request->status,
            'admin_id' => Auth::user()->id,
            'category_id' => $request->category_id
        ]);


        return response()->json([
            "success" => true,
            'data' => $books
        ], 200);

    }

    public function update(Request $request, $book)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name'=>'required|min:2|max:100',
            'author'=>'required|min:2|max:100',
            'image'=>'image|mimes:png,jpeg,jpg,svg',
            'status'=>'required|in:available,borrowed',
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->getMessageBag()->first()]);
        }

        $book = Book::find($book);
        if($request->image){
            Storage::delete($book->image);
            $ex = $request->file('image')->getClientOriginalExtension();
            $filename = Str::slug($request->name);
            $filename = $filename . '-' . date('d-m-Y') . '-' . time() . '.' . $ex;
            $path_image = $request->file('image')->storeAs('uploads/books', $filename);
            $book->image = $path_image;
        }


        Book::updateOrCreate(
            [
                'id' => $book->id
            ],
            [
                'name' => $request->name,
                'author' => $request->author,
                'slug' => Str::slug($request->name),
                'image' => $book->image,
                'status' => $request->status,
                'admin_id' => Auth::user()->id,
                'category_id' => $request->category_id
            ]
        );
        $book = Book::find($book);

        return response()->json([
            'message' => 'Updated Successfull',
            'data' => $book
        ], 200);
    }

    public function destroy($book)
    {
        Book::destroy($book);
        return response()->json([
            'message' => 'deleted Successfull',
            'data' => $book
        ], 200);
    }

}
