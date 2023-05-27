@extends('layouts.partner')

@section('title', 'Export Transaction Records')

@section('content')
    <div class="container">
        @component('partials.page-header', [
    'title' => 'Export Transaction Records',
    ])
        @endcomponent
        <div class="card">
            <div class="card-header">
                <p class="mb-0">
                    All transactions created within the selected date range will be exported to xlsx file. We will notify you via email once the file is ready for download
                </p>
            </div>
            <div class="card-body">
                <form action="{{ route('generate.transfers.report') }}" method="POST" id="generate-report-form">
                    {{ csrf_field() }}
                    <div class="row mb-5">
                        <div class="col">
                            <label class="form-label">
                                <h4>From</h4>
                            </label>
                            <input
                                type="date"
                                name="after"
                                class="form-control"
                                id="after-date"
                                required>
                        </div>
                        <div class="col">
                            <label class="form-label">
                                <h4>To</h4>
                            </label>
                            <input
                                type="date"
                                name="before"
                                class="form-control"
                                id="before-date"
                                required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-primary w-50" id="generate-report-button">Generate Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script>
        form = document.getElementById('generate-report-form');
        document.getElementById('generate-report-button').onclick = function () {
            let afterDate = document.getElementById('after-date').value;
            let beforeDate = document.getElementById('before-date').value;

            if(afterDate && beforeDate){
                swal({
                    title: "Report is being generated.",
                    text: "Your report is being generated. We will notify you via email once the file is ready for download."
                }).then(function(){
                    form.submit();
                })
            }
        }
    </script>
@endpush
