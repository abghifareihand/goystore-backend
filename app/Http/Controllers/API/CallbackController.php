<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Midtrans\CallbackService;
use Illuminate\Http\Request;

class CallbackController extends Controller
{
    public function callback()
    {
        $callback = new CallbackService;
        $transaction = $callback->getOrder();

        if ($callback->isSuccess()) {
            $transaction->update([
                'payment_status' => 'SUCCESS',
            ]);
        }

        if ($callback->isExpire()) {
            $transaction->update([
                'payment_status' => 'EXPIRED',
            ]);
        }

        if ($callback->isCancelled()) {
            $transaction->update([
                'payment_status' => 'CANCELLED',
            ]);
        }

        return response()->json([
            'code' => 200,
            'success' => true,
            'message' => 'Notification midtrans callback success',
        ]);
    }
}
