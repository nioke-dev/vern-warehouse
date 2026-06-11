<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = \App\Models\Order::with('items.variant.product')->orderBy('order_date', 'desc')->get();
        // Load variants with parent product for the selection list.
        // whereHas('product') memastikan hanya varian milik user yang login
        // (Global Scope produk ikut diterapkan di subquery ini).
        $variants = \App\Models\ProductVariant::whereHas('product')->with('product')->get();
        return view('orders', compact('orders', 'variants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:25',
            'items' => 'required|array|min:1',
            'items.*.variant_id' => 'required|exists:product_variants,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        $itemsInput = $request->input('items');
        $totalAmount = 0;
        $orderItemsData = [];
        
        foreach ($itemsInput as $item) {
            $variant = \App\Models\ProductVariant::with('product')->findOrFail($item['variant_id']);
            $qty = intval($item['qty']);
            $price = floatval($variant->selling_price);
            $subtotal = $price * $qty;
            
            $totalAmount += $subtotal;
            
            $orderItemsData[] = [
                'product_variant_id' => $variant->id,
                'variant_name' => $variant->variant_name,
                'product_name' => $variant->product->name,
                'qty' => $qty,
                'price' => $price,
                'subtotal' => $subtotal
            ];
        }

        // Generate unique order ID
        $orderId = 'TRX-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));

        // Create Order
        $order = \App\Models\Order::create([
            'order_id' => $orderId,
            'customer_name' => $request->input('customer_name'),
            'total_amount' => $totalAmount,
            'status' => 'belum lunas',
            'order_date' => date('Y-m-d'),
        ]);

        // Create Order Items & deduct stock
        foreach ($orderItemsData as $itemData) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_variant_id' => $itemData['product_variant_id'],
                'qty' => $itemData['qty'],
                'price' => $itemData['price'],
                'subtotal' => $itemData['subtotal'],
            ]);
            
            $variant = \App\Models\ProductVariant::find($itemData['product_variant_id']);
            if ($variant) {
                $variant->actual_stock = max(0, $variant->actual_stock - $itemData['qty']);
                $variant->save();
            }
        }

        // Prepare Midtrans payload
        $serverKey = env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-y36S1sZ16e_PZ2u3l5s1203S');
        
        $midtransItems = [];
        foreach ($orderItemsData as $itemData) {
            $midtransItems[] = [
                'id' => 'item-' . $itemData['product_variant_id'],
                'price' => (int)$itemData['price'],
                'quantity' => $itemData['qty'],
                'name' => substr($itemData['product_name'] . ' (' . $itemData['variant_name'] . ')', 0, 50),
            ];
        }

        $payload = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int)$totalAmount,
            ],
            'customer_details' => [
                'first_name' => $request->input('customer_name'),
                'phone' => $request->input('phone'),
            ],
            'item_details' => $midtransItems,
        ];

        // Call Midtrans Snap API
        try {
            $response = \Illuminate\Support\Facades\Http::withBasicAuth($serverKey, '')
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
            \Illuminate\Support\Facades\Log::error('Midtrans payment creation failed: ' . $e->getMessage());
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

    public function markAsPaid($orderId)
    {
        $order = \App\Models\Order::where('order_id', $orderId)->first();
        if ($order) {
            $order->status = 'lunas';
            $order->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Order not found'], 404);
    }

    public function handleNotification(Request $request)
    {
        $payload = $request->json()->all();
        
        $orderId = $payload['order_id'] ?? null;
        $statusCode = $payload['status_code'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;
        $signatureKey = $payload['signature_key'] ?? null;
        
        $serverKey = env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-y36S1sZ16e_PZ2u3l5s1203S');
        
        // Verify signature
        $localSignature = hash("sha512", $orderId . $statusCode . $grossAmount . $serverKey);
        
        if ($localSignature !== $signatureKey) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid signature'
            ], 403);
        }
        
        // Find order
        $order = \App\Models\Order::where('order_id', $orderId)->first();
        
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }
        
        $transactionStatus = $payload['transaction_status'] ?? '';
        
        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            $order->status = 'lunas';
        } else if (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $order->status = 'batal';
            // Restore stock of items
            foreach ($order->items ?? [] as $item) {
                $variant = $item->variant;
                if ($variant) {
                    $variant->actual_stock += $item->qty;
                    $variant->save();
                }
            }
        }
        
        $order->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Notification processed successfully'
        ]);
    }
}
