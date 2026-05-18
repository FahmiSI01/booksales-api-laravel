<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index()
    {
        $user = auth('api')->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $cart = Cart::with('items.book')->firstOrCreate(['user_id' => $user->id]);

        return response()->json([
            'success' => true,
            'message' => 'Get Cart Resources',
            'data' => $cart,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $cart = Cart::create([
            'user_id' => $request->user_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cart created successfully',
            'data' => $cart,
        ], 201);
    }

    public function show(string $id)
    {
        $cart = Cart::with('items')->find($id);

        if (! $cart) {
            return response()->json([
                'success' => false,
                'message' => 'Resource Not Found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Resource',
            'data' => $cart,
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $cart = Cart::find($id);

        if (! $cart) {
            return response()->json([
                'success' => false,
                'message' => 'Resource Not Found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'sometimes|required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $cart->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully',
            'data' => $cart,
        ], 200);
    }

    public function destroy(string $id)
    {
        $cart = Cart::find($id);

        if (! $cart) {
            return response()->json([
                'success' => false,
                'message' => 'Resource Not Found',
            ], 404);
        }

        $cart->delete();

        return response()->json([
            'success' => true,
            'message' => 'Delete resource successfully',
        ], 200);
    }
}
