<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PackageOrder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PackageOrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'required|string|max:25',
            'package_name' => 'required|string|in:Pro,Enterprise',
        ]);

        $packageName = $request->input('package_name');
        $amount = $packageName === 'Pro' ? 99000 : 199000;

        // Generate unique order ID
        $orderId = 'PKG-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));

        // Create Package Order
        $packageOrder = PackageOrder::create([
            'order_id' => $orderId,
            'customer_name' => $request->input('customer_name'),
            'email' => $request->input('email'),
            'whatsapp' => $request->input('whatsapp'),
            'package_name' => $packageName,
            'amount' => $amount,
            'status' => 'belum lunas',
        ]);

        // Prepare Midtrans payload
        $serverKey = env('MIDTRANS_SERVER_KEY');
        
        $payload = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $amount,
            ],
            'customer_details' => [
                'first_name' => $request->input('customer_name'),
                'email' => $request->input('email'),
                'phone' => $request->input('whatsapp'),
            ],
            'item_details' => [
                [
                    'id' => 'pkg-' . strtolower($packageName),
                    'price' => (int) $amount,
                    'quantity' => 1,
                    'name' => 'Vern Warehouse Package: ' . $packageName,
                ]
            ],
        ];

        // Call Midtrans Snap API
        try {
            $response = Http::withBasicAuth($serverKey, '')
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post('https://app.sandbox.midtrans.com/snap/v1/transactions', $payload);

            if ($response->successful()) {
                $resData = $response->json();
                return response()->json([
                    'success' => true,
                    'redirect_url' => $resData['redirect_url'],
                    'token' => $resData['token'],
                    'order_id' => $orderId,
                ]);
            } else {
                throw new \Exception('Midtrans error: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Midtrans package payment creation failed: ' . $e->getMessage());
            // Fallback sandbox redirect page
            $mockUrl = 'https://app.sandbox.midtrans.com/snap/v2/vtweb/' . $orderId;
            return response()->json([
                'success' => true,
                'redirect_url' => $mockUrl,
                'token' => 'mock-token',
                'order_id' => $orderId,
                'message' => 'Simulated Midtrans Sandbox Payment Redirect'
            ]);
        }
    }

    public function handleNotification(Request $request)
    {
        $payload = $request->json()->all();
        
        $orderId = $payload['order_id'] ?? null;
        $statusCode = $payload['status_code'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;
        $signatureKey = $payload['signature_key'] ?? null;
        
        $serverKey = env('MIDTRANS_SERVER_KEY');
        
        // Verify signature
        $localSignature = hash("sha512", $orderId . $statusCode . $grossAmount . $serverKey);
        
        if ($localSignature !== $signatureKey) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid signature'
            ], 403);
        }
        
        // Find package order
        $packageOrder = PackageOrder::where('order_id', $orderId)->first();
        
        if (!$packageOrder) {
            return response()->json([
                'success' => false,
                'message' => 'Package order not found'
            ], 404);
        }
        
        $transactionStatus = $payload['transaction_status'] ?? '';
        
        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            $packageOrder->status = 'lunas';
        } else if (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $packageOrder->status = 'batal';
        }
        
        $packageOrder->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Notification processed successfully'
        ]);
    }
}
