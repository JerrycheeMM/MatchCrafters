<?php

$color = [
    \App\Models\Transaction::STATUS_REJECTED => 'warning',
    \App\Models\Transaction::STATUS_PENDING => 'default',
    \App\Models\Transaction::STATUS_SUCCESS => 'success',
];

$statusColor = $color[$transaction->status] ?? 'default';
?>

{{-- TODO: Implement all available transfer statuses with appropriate colors. --}}
<span class="badge badge-{{ $statusColor }}">
    {{ $transaction->readable_status }}
</span>

