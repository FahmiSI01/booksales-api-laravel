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
        $user = auth('api')->user();

        if ($user && $user->role === 'admin') {
            $transactions = Transaction::with(['book', 'user'])->get();
        } else {
            $transactions = Transaction::with('book')->where('customer_id', $user->id)->get();
        }

        if ($transactions->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'No Resources Found',
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get All Resources',
            'data' => $transactions,
        ], 200);
    }

    public function store(Request $request)
    {
        // 1. Validator
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'nullable|string'
        ]);

        // 2. check validator eror
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // 3. insert data
        $number = Transaction::count() + 1;

        $uniqueCode = 'ORD-' . str_pad($number, 4, '0', STR_PAD_LEFT);

        $user = auth('api')->user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        // mencari data buku request
        $book = Book::find($request->book_id);

        // cek stok buku
        if ($book->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok barang tidak cukup',
            ], 400);
        }

        // hitung total harga = price * quantity
        $totalAmount = $book->price * $request->quantity;

        // kurangi stok buku (update)
        $book->stock -= $request->quantity;
        $book->save();

        // simpan data transaksi
        $transaction = Transaction::create([
            'order_number' => $request->order_number ?? $uniqueCode,
            'customer_id' => $user->id,
            'book_id' => $request->book_id,
            'total_amount' => $totalAmount,
            'payment_method' => $request->payment_method ?? 'transfer',
            'payment_status' => $request->payment_status ?? 'unpaid',
            'status' => $request->status ?? 'pending'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Transaction created successfully',
            'data' => $transaction,
        ], 201);
    }

    public function show(string $id)
    {
        $transaction = Transaction::find($id);

        if (! $transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Transaction',
            'data' => $transaction,
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $transaction = Transaction::find($id);

        if (! $transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found',
            ], 404);
        }

        $user = auth('api')->user();
        if ($user->role !== 'admin' && $transaction->customer_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $transaction->update([
            'order_number' => $request->order_number ?? $transaction->order_number,
            'customer_id' => $request->customer_id ?? $transaction->customer_id,
            'book_id' => $request->book_id ?? $transaction->book_id,
            'total_amount' => $request->total_amount ?? $transaction->total_amount,
            'payment_method' => $request->payment_method ?? $transaction->payment_method,
            'payment_status' => $request->payment_status ?? $transaction->payment_status,
            'status' => $request->status ?? $transaction->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Transaction updated successfully',
            'data' => $transaction,
        ], 200);
    }

    public function destroy(string $id)
    {
        $transaction = Transaction::find($id);

        if (! $transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found',
            ], 404);
        }

        $transaction->delete();

        return response()->json([
            'success' => true,
            'message' => 'Transaction deleted successfully',
        ], 200);
    }

    public function destroyAll()
    {
        Transaction::truncate();

        return response()->json([
            'success' => true,
            'message' => 'All transactions have been deleted successfully',
        ], 200);
    }
}
