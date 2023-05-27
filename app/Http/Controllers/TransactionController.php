<?php

namespace App\Http\Controllers;

use App\Filters\AfterFilter;
use App\Filters\BeforeFilter;
use App\Filters\BranchFilter;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Http\Resources\CardResource;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $direction = $request->input('direction');

        if ($direction == Transaction::DIRECTION_SEND) {
            $transactions = $user->sendingTransactions();
        } elseif ($direction == Transaction::DIRECTION_RECEIVE) {
            $transactions = $user->receivingTransactions();
        } else {
            $transactions = Transaction::where('sender_id', $user->id)
                ->orWhere('receiver_id', $user->id);
        }

        $query = QueryBuilder::for($transactions)
            ->allowedFilters([
                AllowedFilter::custom('before', new BeforeFilter),
                AllowedFilter::custom('after', new AfterFilter),
            ])
            ->paginate(20);


        return TransactionResource::collection($query);
    }

    public function store(StoreTransactionRequest $request, $accountNumber)
    {
        $user = $request->user();
        $receiverUser = User::where('account_number', $accountNumber)->firstOrFail();
        $amount = $request->input('amount');

        if ($user->id == $receiverUser->id) {
            return response()->json('account_number is invalid.', 400);
        }

        if ($user->balance < $amount) {
            return response()->json('Insufficent balance.', 400);
        }

        if ($receiverUser->role == User::ROLE_WITHDRAWAL_MERCHANT) {
            $transactions = new Transaction([
                'type' => Transaction::TYPE_CASH_WITHDRAWAL,
                'currency' => 'MYR',
                'description' => $request->input('description'),
                'status' => Transaction::STATUS_PENDING,
                'amount' => $amount,
                'withdrawal_security_code' => (new Transaction)->generateNanoid(10)
            ]);
        } elseif ($receiverUser->role == User::ROLE_MERCHANT) {
            $transactions = new Transaction([
                'type' => Transaction::TYPE_QRPAY,
                'currency' => 'MYR',
                'description' => $request->input('description'),
                'status' => Transaction::STATUS_SUCCESS,
                'amount' => $amount
            ]);
        } elseif ($receiverUser->role == User::ROLE_USER) {
            $transactions = new Transaction([
                'type' => Transaction::TYPE_CARD_TRANSACTION,
                'currency' => 'MYR',
                'description' => $request->input('description'),
                'status' => Transaction::STATUS_SUCCESS,
                'amount' => $amount
            ]);
        }

        $transactions->sender()->associate($user);
        $transactions->receiver()->associate($receiverUser);
        $transactions->save();

        $increment = round($amount, 2) * -1;
        $user->increment('balance', $increment);

        if ($receiverUser->role == User::ROLE_USER) {
            $receiverUser->increment('balance', round($amount, 2));
        }

        return new TransactionResource($transactions);
    }

    public function update(UpdateTransactionRequest $request, $transactionId)
    {
        $user = $request->user();
        $transaction = Transaction::findOrFail($transactionId);

        if ($transaction->status != Transaction::STATUS_PENDING ||
            $transaction->receiver_id != $user->id ||
            $transaction->receiver->role != User::ROLE_WITHDRAWAL_MERCHANT ||
            $transaction->withdrawal_security_code != $request->input('withdrawal_security_code')
        ) {
            return response()->json('You cannot edit transaction status.', 403);
        }

        $status = $request->input('status');

        $transaction->update(['status' => $request]);

        if ($status == Transaction::STATUS_REJECTED) {
            $user->increment('balance', round($transaction->amount, 2));
        }

        return new TransactionResource($transaction);
    }
}
