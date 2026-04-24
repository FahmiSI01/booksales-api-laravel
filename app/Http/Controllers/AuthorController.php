<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    public function index(){
        $authors = Author::all();

        if($authors->isEmpty()){
            return response()->json([
                "success" => true,
                "message" => "No Resources Found",
            ], 200);
        }

        return response()->json([
            "success" => true,
            "message" => "Get All Resources",
            "data" => $authors
        ], 200);
    }

    public function store(Request $request){
        // 1. Validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'bio' => 'required|string',
        ]);
        // 2. check validator eror
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()
            ], 422);
        }
        // 3. upload image
        $image = $request->file('photo');
        $image->store('authors', 'public');
        // 4. insert data
        $author = Author::create([
            'name' => $request->name,
            'photo' => $image->hashName(),
            'bio' => $request->bio,
        ]);
        // 5. response
        return response()->json([
            "success" => true,
            "message" => "Resource added successfully",
            "data" => $author
        ], 201);
    }

    public function show(string $id){
        $author = Author::find($id);

        if(!$author){
            return response()->json([
                "success" => false,
                "message" => "Resource Not Found",
            ], 404);
        }

        return response()->json([
            "success" => true,
            "data" => $author
        ], 200);
    }

    public function update(Request $request, string $id){
        $author = Author::find($id);

        if(!$author){
            return response()->json([
                "success" => false,
                "message" => "Resource Not Found",
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'photo' => 'image|mimes:jpeg,png,jpg|max:2048',
            'bio' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()
            ], 422);
        }
        $data = [
            'name' => $request->name,
            'bio' => $request->bio,
        ];

        if($request->hasFile('photo')){
            $image = $request->file('photo');
            $image->store('authors', 'public');

            if($author->photo){
                Storage::disk('public')->delete('authors/'.$author->photo);
            }

            $data['photo'] = $image->hashName();
        }

        $author->update($data);

        return response()->json([
            "success" => true,
            "message" => "Resource updated successfully",
            "data" => $author
        ], 200);
    }

    public function destroy(string $id){
        $author = Author::find($id);

        if(!$author){
            return response()->json([
                "success" => false,
                "message" => "Resource Not Found",
            ], 404);
        }

        if($author->photo){
            Storage::disk('public')->delete('authors/'.$author->photo);
        }

        $author->delete();

        return response()->json([
            "success" => true,
            "message" => "Delete resource successfully",
        ], 200);
    }
}
