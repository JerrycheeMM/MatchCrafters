@extends('layouts.partner')

@section('title', 'RemitFX - Transfer Import')

@section('menu.upload', 'active')

@section('content')
    <div class="container">
        @component('partials.page-header', [
            'title' => 'Transfer Import',
        ])
            @slot('description')
                Bulk upload your Transfers in CSV format.
            @endslot
            <div class="ml-auto">
                <div class="btn-group btn-sm">
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        Reference
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('reference.nationalities') }}">List of Nationalities</a>
                        <a class="dropdown-item" href="{{ route('reference.countries') }}">List of Countries</a>
                        <a class="dropdown-item" href="{{ route('reference.banks') }}">List of Banks</a>
                        <a class="dropdown-item" href="{{ route('reference.customerTypes') }}">List of Customer Types</a>
                        <a class="dropdown-item" href="{{ route('reference.relationships') }}">List of Relationships</a>
                        <a class="dropdown-item" href="{{ route('reference.regencyCodes') }}">List of Regency Codes</a>
                        <a class="dropdown-item" href="{{ route('reference.purposes') }}">List of Purposes</a>
                        <a class="dropdown-item" href="{{ route('reference.sourceOfFunds') }}">List of Source of Funds</a>
                        <a class="dropdown-item" href="{{ route('reference.australianStates') }}">List of Australian States</a>
                        <a class="dropdown-item" href="{{ route('reference.australianSuburbs') }}">List of Australian Suburbs</a>
                    </div>
                </div>
            </div>

            <span class="fe fe-help-circle mr-2"></span>
            <form method="POST" action="{{ route('transfer.import.download.sample') }}">
                @csrf
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" id="download-sample-csv">Download CSV Sample</button>
                </div>
            </form>
        @endcomponent

        <form action="{{ route('transfer.import.prepare') }}"
              class="dropzone transfers-import mb-5"></form>

        <div id="dz-init-template" class="d-none">
            <div class="fe fe-upload mb-2" style="font-size:2rem"></div>
            Click to browse or drop your files here.
        </div>

        <div id="dz-preview-template" class="d-none">
            <div class="dz-preview dz-file-preview m-0 mb-4">
                <div class="dz-details">
                    <div class="fe fe-file d-none d-sm-block" style="font-size:1.5rem"></div>
                    <div class="d-flex flex-column ml-0 ml-sm-4">
                        <div class="dz-filename"><span data-dz-name></span></div>
                        <span class="status text-muted">Reading file..</span>
                    </div>
                    <div class="fe fe-check text-success ml-auto d-none" style="font-size:1.3rem"></div>
                    <div class="fe fe-x text-danger ml-auto d-none" data-dz-remove title="Remove"
                         style="font-size:1.3rem"></div>
                    <div class="btn btn-submit btn-sm btn-primary ml-auto d-none"
                         data-target="{{ route('transfer.import.store') }}">Submit
                    </div>
                </div>
                <div class="errors text-danger   py-3 px-5 d-none"></div>
                <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
            </div>
        </div>
    </div>
@stop
