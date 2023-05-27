<?php

$color = [
    \App\Models\Transaction::STATUS_REJECTED => 'warning',
    \App\Models\Transaction::STATUS_PENDING => 'default',
    \App\Models\Transaction::STATUS_SUCCESS => 'success',
];
?>

<tr>
    <td>
{{--        <a href="{{ route('transactions.page.show', $transaction) }}">--}}
            <span data-container="body" data-toggle="popover" data-html="true" tabindex="0" data-trigger="focus hover"
                data-placement="right">
                {{ $transaction->id }}
            </span>
        </a>
    </td>
    <td>
        <span data-container="body" data-toggle="popover" data-html="true" tabindex="0" data-trigger="focus hover"
            data-placement="right">
            {{ $transaction->sender->name }}
        </span>
    </td>
    <td>
        <span data-container="body" data-toggle="popover" data-html="true" tabindex="0" data-trigger="focus hover"
            data-placement="right">
            {{ $transaction->receiver->name }}
        </span>
    </td>
    <td class="text-right">{{ $transaction->amount }}</td>
    <td class="text-right">{{ $transaction->description }}</td>
    <td class="text-right">{{ (is_null($user) ? null : $transaction->sender_id == $user->id) ? \App\Models\Transaction::DIRECTION_SEND : \App\Models\Transaction::DIRECTION_RECEIVE }}</td>

    <td>
        {{ $transaction->status }}
    </td>
    <td class="text-right">{{ $transaction->withdrawal_security_code }}</td>
    @if ($transaction->created_at->diffInDays() >= 1)
        <td>{{ $transaction->created_at->format('d/m/y g:i A') }}</td>
    @else
        <td title="{{ $transaction->created_at->format('d/m/y g:i A') }}">{{ $transaction->created_at->diffForHumans() }}
        </td>
    @endif
    <td>
        <div class="card-options">
            <a href="{{ route('transactions.page.approve', ['transactionId' => $transaction->id]) }}"
               class="btn btn-secondary btn-sm">Approve</a>
        </div>
        <div class="card-options">
            <a href="{{ route('transactions.page.reject', ['transactionId' => $transaction->id]) }}"
               class="btn btn-secondary btn-sm">Reject</a>
        </div>
    </td>
</tr>
