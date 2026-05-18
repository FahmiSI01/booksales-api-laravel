<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartItemController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::all();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'No Resources Found',
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get All Resources',
            'data' => $cartItems,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cart_id' => 'required|exists:carts,id',
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $cartItem = CartItem::create([
            'cart_id' => $request->cart_id,
            'book_id' => $request->book_id,
            'quantity' => $request->quantity,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cart Item created successfully',
            'data' => $cartItem,
        ], 201);
    }

    public function show(string $id)
    {
        $cartItem = CartItem::find($id);

        if (! $cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Resource Not Found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Resource',
            'data' => $cartItem,
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $cartItem = CartItem::find($id);

        if (! $cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Resource Not Found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'cart_id' => 'sometimes|required|exists:carts,id',
            'book_id' => 'sometimes|required|exists:books,id',
            'quantity' => 'sometimes|required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $cartItem->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Cart Item updated successfully',
            'data' => $cartItem,
        ], 200);
    }

    public function destroy(string $id)
    {
        $cartItem = CartItem::find($id);

        if (! $cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Resource Not Found',
            ], 404);
        }

        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Delete resource successfully',
        ], 200);
    }
}
