<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Transaction Order";
        $orders = Order::with('orderDetails.product')->latest()->get();
        return view('order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Point of Sales";
        $categories = Category::get();
        $products = Product::with('category')->orderBy('id')->get();
        return view('order.create', compact('title', 'categories', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'payment_method' => 'nullable|string',
            'customer_name' => 'nullable|string',
            'order_change' => 'nullable|numeric',
        ]);

        $paymentMethod = $request->payment_method ?? 'cash';

        // 1. Memastikan array items selalu bernilai indexed array (0, 1, 2...)
        $items = is_array($request->items) ? array_values($request->items) : [];

        try {
            $order = DB::transaction(function () use ($items, $request, $paymentMethod) {
                $subtotal = 0;
                $itemsData = [];

                foreach ($items as $item) {
                    $productId = $item['id'] ?? null;
                    $qty = $item['qty'] ?? 1;

                    if (!$productId) {
                        continue;
                    }

                    $product = Product::findOrFail($productId);

                    if ($product->qty < $qty) {
                        throw new \Exception('Stok produk "' . $product->name . '" tidak cukup');
                    }

                    $itemSubtotal = $product->price * $qty;
                    $subtotal += $itemSubtotal;

                    $itemsData[] = [
                        'product_id' => $product->id,
                        'order_qty' => $qty,
                        'order_price' => $product->price,
                        'order_subtotal' => $itemSubtotal,
                    ];
                }

                // 2. Hitung Pajak 10% agar presisi sesuai hitungan Frontend (POS)
                $tax = $subtotal * 0.10;
                $totalAmount = $subtotal + $tax;

                $order = Order::create([
                    'order_code' => 'ORD-' . strtoupper(Str::random(8)),
                    'customer_name' => $request->customer_name,
                    'payment_method' => $paymentMethod,
                    'order_amount' => $totalAmount, // Total sudah termasuk Pajak 10%
                    'order_change' => $request->order_change ?? 0,
                    'status' => $paymentMethod === 'cash' ? 1 : 0,
                ]);

                foreach ($itemsData as $data) {
                    OrderDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $data['product_id'],
                        'order_qty' => $data['order_qty'],
                        'order_price' => $data['order_price'],
                        'order_subtotal' => $data['order_subtotal'],
                    ]);

                    Product::where('id', $data['product_id'])
                        ->decrement('qty', $data['order_qty']);
                }

                return $order;
            });

            $snapToken = null;

            // 3. Integrasi Midtrans Snap
            if ($paymentMethod === 'midtrans') {
                Config::$serverKey = config('services.midtrans.server_key');
                Config::$isProduction = config('services.midtrans.is_production', false);
                Config::$isSanitized = true;
                Config::$is3ds = true;

                // Bypass SSL verification untuk localhost/XAMPP (banyak setup Windows
                // tidak punya CA bundle terpasang, tanpa ini request bisa hang lama
                // sebelum akhirnya timeout). Jangan dipakai di production.
                // Config::$curlOptions = [
                //    CURLOPT_SSL_VERIFYPEER => false,
                //    CURLOPT_SSL_VERIFYHOST => false,
                //    CURLOPT_CONNECTTIMEOUT => 10,
                //    CURLOPT_TIMEOUT => 15,
                // ];

                $params = [
                    'transaction_details' => [
                        'order_id' => $order->order_code,
                        'gross_amount' => (int) round($order->order_amount),
                    ],
                    'customer_details' => [
                        'first_name' => $request->customer_name ?? 'Customer',
                    ],
                    'enabled_payments' => ['gopay', 'qris'],
                ];

                $snapToken = Snap::getSnapToken($params);
            }

            return response()->json([
                'success' => true,
                'payment_method' => $paymentMethod,
                'snap_token' => $snapToken,
                'order_id' => $order->id,
            ]);
        } catch (Exception $th) {
            return response()->json([
                'message' => 'Gagal Menyimpan Transaksi: ' . $th->getMessage(),
            ], 500);
        }
    }

    public function printReceipt(string $id)
    {
        $order = Order::with('orderDetails.product')->findOrFail($id);
        return view('order.print', compact('order'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $title = "Order Detail";
        $order = Order::with('orderDetails.product')->findOrFail($id);
        return view('order.show', compact('title', 'order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->to('order')->with('success', 'Order deleted successfully');
    }
}
