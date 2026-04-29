<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();

        if($transactions->isEmpty()){
            return response()->json([
                "success" => true,
                "message" => "No Resources Found",
            ], 200);
        }

        return response()->json([
            "success" => true,
            "message" => "Get All Resources",
            "data" => $transactions
        ], 200);
    }

    public function store(Request $request)
    {
        // 1. Validator
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id',
            'customer_id' => 'required|exists:users,id',
        ]);

        // 2. check validator eror
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => 'Validation Error',
                "errors" => $validator->errors()
            ], 422);
        }

        // 3. insert data
        $uniqueCode = "ORD-" . strtoupper(uniqid());

        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                "success" => false,
                "message" => "Unauthorized"
            ], 401);
        }

        //mencari data buku request
        $book = Book::find($request->book_id);

        //cek stok buku
        if ($book->stock < $request->quantity) {
            return response()->json([
                "success" => false,
                "message" => "Stok barang tidak cukup"
            ], 400);
        }

        //hitung total harga = price * quantity
        $totalAmount = $book->price * $request->quantity;

        //kurangi stok buku (update)
        $book->stock -= $request->quantity;
        $book->save();

        //simpan data transaksi
        $transaction = Transaction::create([
            'order_number' => $uniqueCode,
            'customer_id' => $request->customer_id,
            'book_id' => $request->book_id,
            'total_amount' => $totalAmount,
        ]);

        return response()->json([
            "success" => true,
            "message" => "Transaction created successfully",
            "data" => $transaction
        ], 201);
    }
}
