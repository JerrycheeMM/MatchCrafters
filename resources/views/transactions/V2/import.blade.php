@extends('layouts.partner')

@section('title', 'MatchCrafters - Transfer Import')

@section('menu.upload', 'active')

@section('content')
    <div class="container">
        @component('partials.page-header', [
            'title' => 'Transfer Import',
        ])
            @slot('description')
                Bulk upload your Transfers in CSV format.
            @endslot
                <form method="POST" action="{{ route('transfer.import.download.sample') }}">
                    @csrf
                    <div class="input-group">
                        <select name="type_of_customer" id="type_of_customer" class="custom-select form-control" required="required" onchange="enableButton();payoutMethod()">
                            <option value="" selected disabled>-- Pick A Sender Entity Type --</option>
                            @foreach($entityTypes as $entityTypeValue => $entityTypeKey)
                                <option value="{{{$entityTypeValue}}}">{{{$entityTypeKey}}}</option>
                            @endforeach
                        </select>
                        <select name="type_of_beneficiary" id="type_of_beneficiary" class="custom-select form-control" required="required" onchange="enableButton();payoutMethod()">
                            <option value="" selected disabled>-- Pick A Beneficiary Entity Type --</option>
                            @foreach($entityTypes as $entityTypeValue => $entityTypeKey)
                                <option value="{{{$entityTypeValue}}}">{{{$entityTypeKey}}}</option>
                            @endforeach
                        </select>
                        <select name="to_currency" id="to_currency" class="custom-select form-control" required="required" onchange="toCurrencyChange();payoutMethod()">
                            <option value="" selected disabled>-- Pick A Receiving Currency --</option>
                            @foreach($toCurrencies as $toCurrency)
                                <option value="{{{$toCurrency}}}">{{{$toCurrency}}}</option>
                            @endforeach
                        </select>
                        <select name="beneficiary_country" id="beneficiary_country" class="custom-select form-control" required="required" disabled onchange="enableButton();payoutMethod()">
                            <option value="" selected disabled>-- Pick A Receiving Country --</option>
                        </select>
                        <select name="payout_method" id="payout_method" class="custom-select form-control" disabled required="required" onchange="enableButton()">
                            <option value="" selected disabled>-- Pick A Payout Method --</option>
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit" id="download-sample-csv" disabled>Download CSV Sample</button>
                        </div>
                    </div>
                </form>
        @endcomponent

        <form action="{{ route('transfer.import.prepare')  }}" class="dropzone transfers-import mb-5"></form>

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
@endsection

@section('custom-js')
<script>
    function toCurrencyChange() {
        let toCurrency = document.getElementById("to_currency").value;
        let typeOfCustomer = document.getElementById('type_of_customer').value;
        let typeOfBeneficiary = document.getElementById('type_of_beneficiary').value;

        let beneficiaryCountryField = document.getElementById('beneficiary_country');
        let beneficiaryCountryFieldOptions = beneficiaryCountryField.options;

        let payoutMethodField = document.getElementById('payout_method');
        let payoutMethodFieldOptions = payoutMethodField.options;

        for (let i = beneficiaryCountryFieldOptions.length - 1; i >= 1; i--) {
            beneficiaryCountryField.remove(i);
        }
        for (let i = payoutMethodFieldOptions.length - 1; i >= 1; i--) {
            payoutMethodField.remove(i);
        }

        let xhttp = new XMLHttpRequest();

        let params = new URLSearchParams({
            to_currency: toCurrency,
            type_of_customer: typeOfCustomer,
            type_of_beneficiary: typeOfBeneficiary
        });
        xhttp.open("GET", "get-beneficiary-countries?" + params.toString(), true);
        xhttp.onreadystatechange = function() {
            if(xhttp.readyState === 4 && xhttp.status === 200) {
                let countryList = JSON.parse(xhttp.response);
                for (const [key, value] of Object.entries(countryList)) {
                    let option = document.createElement("option");
                    option.text = key;
                    option.value = value;
                    beneficiaryCountryField.appendChild(option);
                }
            }
        }
        xhttp.send();
        beneficiaryCountryField.disabled = 0;
        beneficiaryCountryField.selectedIndex = 0;
        enableButton();
    }

    function payoutMethod(){
        let toCurrency = document.getElementById('to_currency').value;
        let typeOfCustomer = document.getElementById('type_of_customer').value;
        let typeOfBeneficiary = document.getElementById('type_of_beneficiary').value;
        let beneficiaryCountry = document.getElementById('beneficiary_country').value;

        let payoutMethodField = document.getElementById('payout_method');
        let payoutMethodFieldOptions = payoutMethodField.options;

        for (let i = payoutMethodFieldOptions.length - 1; i >= 1; i--) {
            payoutMethodField.remove(i);
        }

        let xhttp = new XMLHttpRequest();

        if (toCurrency && typeOfCustomer && typeOfBeneficiary && beneficiaryCountry ){
            let params = new URLSearchParams({
                to_currency: toCurrency,
                type_of_customer: typeOfCustomer,
                type_of_beneficiary: typeOfBeneficiary,
                beneficiary_country: beneficiaryCountry
            });
            xhttp.open("GET", "get-country-payout-methods?" + params.toString(), true);

            xhttp.onreadystatechange = function() {
                if(xhttp.readyState === 4 && xhttp.status === 200) {
                    let payoutMethod = JSON.parse(xhttp.response);
                    for (const [key, value] of Object.entries(payoutMethod)) {
                        let option = document.createElement("option");
                        option.text = value;
                        option.value = key;
                        payoutMethodField.appendChild(option);
                    }
                }
            }
            xhttp.send();
            payoutMethodField.disabled = 0;
            payoutMethodField.selectedIndex = 0;
            enableButton();
        }
    }

    function removeOptions(selectElement) {
        let i, L = selectElement.options.length - 1;
        for(i = L; i >= 0; i--) {
            selectElement.remove(i);
        }
    }

    function enableButton()
    {
        let toCurrency = document.getElementById('to_currency');
        let typeOfCustomer = document.getElementById('type_of_customer');
        let typeOfBeneficiary = document.getElementById('type_of_beneficiary');
        let beneficiaryCountry = document.getElementById('beneficiary_country');
        let payoutMethod = document.getElementById('payout_method');
        let submitButton = document.getElementById('download-sample-csv');

        if (toCurrency.options[toCurrency.selectedIndex].value
            && typeOfCustomer.options[typeOfCustomer.selectedIndex].value
            && typeOfBeneficiary.options[typeOfBeneficiary.selectedIndex].value
            && beneficiaryCountry.options[beneficiaryCountry.selectedIndex].value
            && payoutMethod.options[payoutMethod.selectedIndex].value
        ) {
            submitButton.disabled = 0;
        } else {
            submitButton.disabled = 1;
        }
    }
</script>
@endsection
