@component('partials.page-header', [
            'title' => 'Transactions Records',
        ])
    @if($transactions->count() > 0)
        @slot('description')
            Showing rows {{ $transactions->firstItem() }} - {{ $transactions->lastItem() }} from
            total {{ $transactions->total() }} results.
        @endslot
    @endif
@endcomponent
