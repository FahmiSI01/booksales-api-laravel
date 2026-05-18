<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Transaction;

class MidtransController extends Controller
{

    public function getToken(Request $request)
    {
        $request->validate([
            'total' => 'required|numeric',
            'items' => 'required|array',
        ]);

        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED', true);
        Config::$is3ds = env('MIDTRANS_IS_3DS', true);

        $item_details = array_map(function ($item) {
            return [
                'id'       => $item['id'],
                'price'    => $item['price'],
                'quantity' => $item['quantity'],
                'name'     => substr($item['name'], 0, 50),
            ];
        }, $request->items);

        $user = auth('api')->user();

        $orderId = $request->order_number
            ?? ('TRX-' . time() . '-' . rand(100, 999));

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $request->total,
            ],
            'item_details' => $item_details,
            'customer_details' => [
                'first_name' => $user->name ?? 'Customer',
                'email'      => $user->email ?? 'customer@example.com',
            ],
        ];

        if ($request->has('payment_type')) {

            $paymentType = $request->payment_type;

            if ($paymentType === 'transfer') {

                $params['enabled_payments'] = [
                    'bca_va',
                    'bni_va',
                    'bri_va',
                    'echannel',
                    'permata_va',
                    'other_va'
                ];
            } else if ($paymentType === 'ewallet') {

                $params['enabled_payments'] = [
                    'gopay',
                    'shopeepay'
                ];
            } else if ($paymentType === 'qris') {

                $params['enabled_payments'] = [
                    'other_qris',
                    'gopay'
                ];
            }
        }


        try {

            $snapToken = Snap::getSnapToken($params);

            return response()->json([
                'token' => $snapToken
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function callback(Request $request)
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');

        $signature = hash(
            'sha512',
            $request->order_id .
                $request->status_code .
                $request->gross_amount .
                env('MIDTRANS_SERVER_KEY')
        );

        if ($signature != $request->signature_key) {

            return response()->json([
                'message' => 'Invalid signature'
            ], 403);
        }

        $transactions = Transaction::where('order_number', $request->order_id)->get();

        if ($transactions->isEmpty()) {
            return response()->json([
                'message' => 'Transaction not found'
            ], 404);
        }

        foreach ($transactions as $transaction) {
            if (
                $request->transaction_status == 'settlement' ||
                $request->transaction_status == 'capture'
            ) {
                $transaction->payment_status = 'paid';
                $transaction->status = 'success'; // Frontend uses 'success'
            } elseif ($request->transaction_status == 'pending') {
                $transaction->payment_status = 'unpaid';
                $transaction->status = 'pending';
            } elseif (
                $request->transaction_status == 'expire' ||
                $request->transaction_status == 'cancel' ||
                $request->transaction_status == 'deny'
            ) {
                $transaction->payment_status = 'failed';
                $transaction->status = 'cancelled';
            }
            $transaction->save();
        }

        return response()->json([
            'message' => 'Payment status updated'
        ]);
    }
}
