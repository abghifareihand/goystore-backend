<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            $transaction = Transaction::with(['items.product'])->find($id);

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

        $transaction = Transaction::with(['items.product'])->where('user_id', Auth::user()->id);

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
            'items' => 'required|array', // validasi items array
            'items.*.id' => 'exists:products,id', // validasi dasi yg ada di dalam items
            'total_price' => 'required',
        ]);

        $transaction = Transaction::create([
            'user_id' => $request->user()->id,
            'transaction_number' => 'TRX' . time(),
            'address' => $request->address,
            'total_price' => $request->total_price,
            'shipping_price' => $request->shipping_price,
            'payment_status' => 'PENDING',
            'payment_url' => now(),
        ]);

        foreach ($request->items as $product) {
            TransactionItem::create([
                'user_id' => $request->user()->id,
                'transaction_id'=> $transaction->id,
                'product_id' => $product['id'],
                'quantity'=> $product['quantity'],
            ]);
        }

        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Transaksi berhasil',
            'data' => $transaction->load('items.product')
        ]);
    }
}
