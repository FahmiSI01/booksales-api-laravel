<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionDetailController extends Controller
{
    public function index()
    {
        $transactionDetails = TransactionDetail::all();

        if ($transactionDetails->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'No Resources Found',
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get All Resources',
            'data' => $transactionDetails,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaction_id' => 'required|exists:transactions,id',
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $transactionDetail = TransactionDetail::create([
            'transaction_id' => $request->transaction_id,
            'book_id' => $request->book_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Transaction Detail created successfully',
            'data' => $transactionDetail,
        ], 201);
    }

    public function show(string $id)
    {
        $transactionDetail = TransactionDetail::find($id);

        if (! $transactionDetail) {
            return response()->json([
                'success' => false,
                'message' => 'Resource Not Found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Resource',
            'data' => $transactionDetail,
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $transactionDetail = TransactionDetail::find($id);

        if (! $transactionDetail) {
            return response()->json([
                'success' => false,
                'message' => 'Resource Not Found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'transaction_id' => 'sometimes|required|exists:transactions,id',
            'book_id' => 'sometimes|required|exists:books,id',
            'quantity' => 'sometimes|required|integer|min:1',
            'price' => 'sometimes|required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $transactionDetail->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Transaction Detail updated successfully',
            'data' => $transactionDetail,
        ], 200);
    }

    public function destroy(string $id)
    {
        $transactionDetail = TransactionDetail::find($id);

        if (! $transactionDetail) {
            return response()->json([
                'success' => false,
                'message' => 'Resource Not Found',
            ], 404);
        }

        $transactionDetail->delete();

        return response()->json([
            'success' => true,
            'message' => 'Delete resource successfully',
        ], 200);
    }
}
