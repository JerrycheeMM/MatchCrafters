<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCreditNotificationRequest;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Card;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class CreditNotificationController extends Controller
{
    public function store(StoreCreditNotificationRequest $request, $accountNumber)
    {
        $receiverUser = User::where('account_number', $accountNumber)->firstOrFail();
        $amount = $request->input('amount');

        $transactions = new Transaction([
            'type' => Transaction::TYPE_MONEY_ADDED,
            'currency' => 'MYR',
            'description' => 'Deposited from ' . (new Card)->generateNanoid(10),
            'status' => Transaction::STATUS_SUCCESS,
            'amount' => $amount
        ]);

        $transactions->receiver()->associate($receiverUser);
        $transactions->save();
        $receiverUser->increment('balance', round($amount, 2));

        return new TransactionResource($transactions);
    }
}
