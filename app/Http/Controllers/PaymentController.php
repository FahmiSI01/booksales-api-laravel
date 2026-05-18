<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::all();

        if ($payments->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'No Resources Found',
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get All Resources',
            'data' => $payments,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaction_id' => 'required|exists:transactions,id',
            'payment_method' => 'required|string|max:255',
            'amount' => 'required|integer|min:0',
            'status' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $payment = Payment::create([
            'transaction_id' => $request->transaction_id,
            'payment_method' => $request->payment_method,
            'amount' => $request->amount,
            'status' => $request->status ?? 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment created successfully',
            'data' => $payment,
        ], 201);
    }

    public function show(string $id)
    {
        $payment = Payment::find($id);

        if (! $payment) {
            return response()->json([
                'success' => false,
                'message' => 'Resource Not Found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Resource',
            'data' => $payment,
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $payment = Payment::find($id);

        if (! $payment) {
            return response()->json([
                'success' => false,
                'message' => 'Resource Not Found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'transaction_id' => 'sometimes|required|exists:transactions,id',
            'payment_method' => 'sometimes|required|string|max:255',
            'amount' => 'sometimes|required|integer|min:0',
            'status' => 'sometimes|required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $payment->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Payment updated successfully',
            'data' => $payment,
        ], 200);
    }

    public function destroy(string $id)
    {
        $payment = Payment::find($id);

        if (! $payment) {
            return response()->json([
                'success' => false,
                'message' => 'Resource Not Found',
            ], 404);
        }

        $payment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Delete resource successfully',
        ], 200);
    }
}
