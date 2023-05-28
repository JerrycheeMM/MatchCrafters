<?php

namespace App\Http\Controllers;

use App\Exports\TransfersExport;
use App\Filters\AfterFilter;
use App\Filters\BeforeFilter;
use App\Http\Requests\UpdateTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TransactionPageController extends Controller
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


        return view('transactions.index', [
            'transactions' => $query,
            'user' => $user
        ]);
    }

    public function export(Request $request)
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

        return (new TransfersExport($query, $user))->download('transactions-' . time() . '.csv');
    }

    public function approve(Request $request, $transactionId)
    {
        $user = $request->user();
        $transaction = Transaction::findOrFail($transactionId);

        if ($transaction->status != Transaction::STATUS_PENDING ||
            $transaction->receiver_id != $user->id ||
            $transaction->receiver->role != User::ROLE_WITHDRAWAL_MERCHANT
        ) {
            return back()->with('msg_error', 'Unable to approve order !');
        }


        $transaction->update(['status' => Transaction::STATUS_SUCCESS]);
        return back()->with('msg_success', 'Transaction Approved!');
    }

    public function reject(Request $request, $transactionId)
    {
        $user = $request->user();
        $transaction = Transaction::findOrFail($transactionId);


        if ($transaction->status != Transaction::STATUS_PENDING ||
            $transaction->receiver_id != $user->id ||
            $transaction->receiver->role != User::ROLE_WITHDRAWAL_MERCHANT
        ) {
            return back()->with('msg_error', 'Unable to reject order !');
        }

        $transaction->update(['status' => Transaction::STATUS_REJECTED]);
        $transaction->sender->increment('balance', round($transaction->amount, 2));

        return back()->with('msg_success', 'Transaction Rejected!');
    }
}
