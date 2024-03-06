<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
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
}
