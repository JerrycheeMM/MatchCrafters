@extends('layouts.partner')

@section('title', 'RemitFX - Transfer Records')

@section('menu.past-transfers', 'active')

@section('content')
    <div class="container">
        @include('transactions.partials.page-header')
        @include('transactions.partials.index')
    </div>
@stop

@section("transfer-filter-js")
    <script>
        const todayStr = new Date().toISOString().split('T')[0]
        $("#start-date").on('input', function (e) {
            if ($('#start-date').val() !== "") {
                let minDate = new Date($('#start-date').val());
                let minDateStr = minDate.toISOString().split('T')[0]
                $("#end-date").attr("min", minDateStr);

                // 7 Days range
                let maxDate = new Date(minDateStr);
                maxDate.setDate(maxDate.getDate() + 6);
                let maxDateStr = maxDate.toISOString().split('T')[0];
                $("#end-date").attr("max", maxDateStr);
                $("#end-date").val(minDateStr);
            } else {
                $("#end-date").val(todayStr);
                $("#start-date").val(todayStr);
            }
        })
    </script>
@endsection
