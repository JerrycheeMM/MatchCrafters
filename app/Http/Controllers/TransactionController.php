<?php

namespace App\Http\Controllers;

use App\Filters\AfterFilter;
use App\Filters\BeforeFilter;
use App\Filters\BranchFilter;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Resources\CardResource;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
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
            $transactions = Transaction::where('sender_id', $user->id)->orWhere('receiver_id', $user->id);
        }

        $transactions = QueryBuilder::for($transactions)
            ->allowedFilters([
                AllowedFilter::custom('before', new BeforeFilter),
                AllowedFilter::custom('after', new AfterFilter),
            ])
            ->orderBy('asc')
            ->paginate(20);

        return TransactionResource::collection($transactions);
    }

    public function store(StoreTransactionRequest $request, $accountNumber)
    {
        $user = $request->user();
        $receiverUser = User::where('account_number', $accountNumber)->firstOrFail();

        if ($receiverUser->role == User::ROLE_WITHDRAWAL_MERCHANT) {
            $transactions = new Transaction([
                'type' => Transaction::TYPE_CASH_WITHDRAWAL,
                'currency' => 'MYR',
                'description' => $request->input('description'),
                'status' => Transaction::STATUS_PENDING,
                'amount' => $request->input('amount')
            ]);
        } elseif ($receiverUser->role == User::ROLE_MERCHANT) {
            $transactions = new Transaction([
                'type' => Transaction::TYPE_QRPAY,
                'currency' => 'MYR',
                'description' => $request->input('description'),
                'status' => Transaction::STATUS_SUCCESS,
                'amount' => $request->input('amount')
            ]);
        } elseif ($receiverUser->role == User::ROLE_USER) {
            $transactions = new Transaction([
                'type' => Transaction::TYPE_CARD_TRANSACTION,
                'currency' => 'MYR',
                'description' => $request->input('description'),
                'status' => Transaction::STATUS_SUCCESS,
                'amount' => $request->input('amount')
            ]);
        }

        $transactions->sender()->associate($user);
        $transactions->receiver()->associate($receiverUser);
        $transactions->save();

        return new TransactionResource($transactions);
    }
}
