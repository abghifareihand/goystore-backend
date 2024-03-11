<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class TransactionController extends Controller
{
    public function all(Request $request)
    {
        // filter transaction by id
        $id = $request->input('id');
        // filter transaction by limit
        $limit = $request->input('limit');
        // filter transaction by status
        $status = $request->input('status');

        if ($id) {
            // relasi agar muncul items.product di response json
            $transaction = Transaction::with(['items.product', 'items.product.galleries'])->find($id);

            if ($transaction) {
                return response()->json([
                    'code' => 200,
                    'success' => true,
                    'message' => 'Data transaksi berhasil diambil',
                    'data' => $transaction
                ]);
            } else {
                return response()->json([
                    'code' => 404,
                    'success' => false,
                    'message' => 'Data transaksi gagal diambil',
                ], 404);
            }
        }

        $transaction = Transaction::with(['items.product', 'items.product.galleries'])->where('user_id', Auth::user()->id);

        if ($status) {
            $transaction->where('status', $status);
        }

        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Data list transaksi berhasil diambil',
            'data' => $transaction->get(),
        ]);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'items' => 'required|array', // validasi items array
            'items.*.id' => 'exists:products,id', // validasi dasi yg ada di dalam items
            'total_price' => 'required',
        ]);

        $transaction = Transaction::create([
            'user_id' => $request->user()->id,
            'transaction_number' => 'TRX' . time(),
            'address' => $request->address,
            'total_price' => $request->total_price,
            'payment_status' => 'PENDING',
        ]);

        foreach ($request->items as $product) {
            TransactionItem::create([
                'user_id' => $request->user()->id,
                'transaction_id' => $transaction->id,
                'product_id' => $product['id'],
                'quantity' => $product['quantity'],
            ]);
        }

        // KONFIGURASI MIDTRANS

        // konfigurasi midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');


        // panggil transaksi yg di buat
        $transaction = Transaction::with(['items.product', 'user'])->find($transaction->id);

        // Mengisi array item details dengan data produk dalam transaksi
        foreach ($transaction->items as $item) {
            $items_details[] = [
                'id' => $item->product->id,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
                'name' => $item->product->name,
            ];
        }


        $midtrans = [
            'transaction_details' => [
                'order_id' => $transaction->transaction_number,
                'gross_amount' => $transaction->total_price + 24500,
            ],
            'item_details' => $items_details,
            'customer_details' => [
                'first_name' => $transaction->user->name,
                'email' => $transaction->user->email,
            ]
        ];


        // Membuat transaksi Snap Midtrans
        $midtransTransaction = Snap::createTransaction($midtrans);

        // Mendapatkan URL pembayaran dari respons Snap
        $paymentUrl = $midtransTransaction->redirect_url;

        // Menyimpan URL pembayaran ke dalam objek transaksi
        $transaction->payment_url = $paymentUrl;
        $transaction->save();


        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Transaksi berhasil',
            'data' => $transaction
        ]);
    }
}
