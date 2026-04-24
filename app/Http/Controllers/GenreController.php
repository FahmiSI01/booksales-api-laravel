<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{
    public function index(){
        $genres = Genre::all();

        if($genres->isEmpty()){
            return response()->json([
                "success" => true,
                "message" => "No Resources Found",
            ], 200);
        }

        return response()->json([
            "success" => true,
            "message" => "Get All Resources",
            "data" => $genres
        ], 200);
    }

    public function store(Request $request){
        // 1. Validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'description' => 'required|string',
        ]);
        // 2. check validator eror
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()
            ], 422);
        }
        // 3. insert data
        $genre = Genre::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        // 4. response
        return response()->json([
            "success" => true,
            "message" => "Resource added successfully",
            "data" => $genre
        ], 201);
    }

    public function show(string $id){
        $genre = Genre::find($id);

        if(!$genre){
            return response()->json([
                "success" => false,
                "message" => "Resource Not Found",
            ], 404);
        }

        return response()->json([
            "success" => true,
            "data" => $genre
        ], 200);
    }

    public function update(Request $request, string $id){
        $genre = Genre::find($id);

        if(!$genre){
            return response()->json([
                "success" => false,
                "message" => "Resource Not Found",
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()
            ], 422);
        }

        $genre->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json([
            "success" => true,
            "message" => "Resource updated successfully",
            "data" => $genre
        ], 200);
    }

    public function destroy(string $id){
        $genre = Genre::find($id);

        if(!$genre){
            return response()->json([
                "success" => false,
                "message" => "Resource Not Found",
            ], 404);
        }

        $genre->delete();

        return response()->json([
            "success" => true,
            "message" => "Delete resource successfully",
        ], 200);
    }
}