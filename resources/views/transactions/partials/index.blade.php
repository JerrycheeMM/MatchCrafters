@component('partials.cards-deck')
    <div class="card">
            <div class="col-md-12">
                {{-- display error message --}}
                @if(session('msg_error'))
                    <div class="spacer"></div>
                    <div class="col-md-115 alert alert-danger">
                        <ul class="left-pad-35">
                            <li>{{session('msg_error')}}</li>
                        </ul>
                    </div>
                @endif
                {{-- display info message --}}
                @if(session('msg_info'))
                    <div class="spacer"></div>
                    <div class="col-md-115 alert alert-info">
                        <ul class="left-pad-35">
                            <li>{{session('msg_info')}}</li>
                        </ul>
                    </div>
                @endif
                {{-- display succsess message --}}
                @if(session('msg_success'))
                    <div class="spacer"></div>
                    <div class="col-md-115 alert alert-success">
                        <ul class="left-pad-35">
                            <li>{{session('msg_success')}}</li>
                        </ul>
                    </div>
                @endif
            </div>

            <div class="card-header">
                @include('transactions.partials.filters')
                <div class="card-options">

                    <a href="{{ route('transactions.page.export') . '?' . request()->getQueryString() }}"
                       class="btn btn-secondary btn-sm">Export</a>
                </div>
            </div>
            @component('partials.loader')
                    @if($transactions->count() == 0)
                        <div class="card-body">
                            There are no transactions matching your query.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap">
                                @include('transactions.partials.thead')
                                <tbody>
                                @foreach($transactions as $transaction)
                                    @include('transactions.partials.row')
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
            @endcomponent
        </div>
        {{ $transactions->links() }}
@endcomponent
