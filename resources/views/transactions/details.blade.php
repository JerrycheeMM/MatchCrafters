@extends('layouts.partner')

@section('title', 'MatchCrafters - Transfer ' . $transfer->ref . ' details')

@section('content')
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css"
        integrity="sha512-p30E/0J/YYuX9N1/0BNeV7Fm+B17NkV7IflQ05xE2j+Z/KDIZ0C2sZvXsZsTbTtTgUnolFkzvTmdyOgF0q1KA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Include Bootstrap JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"
        integrity="sha512-P4UzROwU6nswUdtUrG+FV7AJg/HFKmiu1ZIje07GaqiV7FygQc90uV7Wfl21+tNHgE0LmLm+qr9VroFg1wsY7g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <div class="container">

        @component('partials.page-header', [
            'title' => 'Transfer Details ' . $transfer->ref,
        ])
            <div class="ml-auto">
                @if (!auth()->user()->isDomestic())
                    <button type="button"
                        class="btn btn-sm btn-danger text-white ml-auto @if (!$transfer->can_cancel || $transfer->is_xcurrent_transfer) d-none @endif"
                        data-toggle="modal" data-target="#cancel-confirmation">
                        Cancel
                    </button>
                @endif
                <a target="_blank" href="{{ route('transfer.page.receipt', $transfer->id) }}"
                    class="btn btn-sm btn-primary text-white ml-2 @if (!in_array($transfer->status, ['PROCESSED', 'CLEARED'])) d-none @endif">
                    Receipt
                </a>
                <div class="modal fade" id="cancel-confirmation" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Cancel Transfer</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <a class="btn btn-danger text-white" onclick="document.getElementById('cancel-form').submit();">
                                    Yes
                                    <form id="cancel-form" method="POST"
                                        action="{{ route('transfer.page.cancel', $transfer) }}" class="d-none">
                                        @csrf
                                        <button type="submit"></button>
                                    </form>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcomponent
        @if (($wcoScreeningStatus === MM\CommonUtilities\Types\RemitfxTransferWCOStatus::ADDITIONAL_INFO_IN_REVIEW && $transfer->wcoScreening->submitted_before) ||
        $wcoScreeningStatus === MM\CommonUtilities\Types\RemitfxTransferWCOStatus::ADDITIONAL_INFO_REQUIRED ||
        $wcoScreeningStatus === MM\CommonUtilities\Types\RemitfxTransferWCOStatus::REJECTED_BY_SANCTION_HIT ||
        ($wcoScreeningStatus === MM\CommonUtilities\Types\RemitfxTransferWCOStatus::CLEARED && $transfer->wcoScreening->submitted_before))
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        @if ($wcoScreeningStatus === MM\CommonUtilities\Types\RemitfxTransferWCOStatus::ADDITIONAL_INFO_IN_REVIEW && $transfer->wcoScreening->submitted_before)
                            <h2>Screening Information Received</h2>
                            <p>Checks in Progress.</p>
                            <p>Please check again later. We are reviewing the information provided.</p>
                        @elseif ($wcoScreeningStatus === MM\CommonUtilities\Types\RemitfxTransferWCOStatus::ADDITIONAL_INFO_REQUIRED)
                            <h2>Screening Information Required</h2>
                            <p>You are required to submit additional information for your order.</p>
                            <p>Please click on "Take Action" for further information</p>
                        @elseif ($wcoScreeningStatus === MM\CommonUtilities\Types\RemitfxTransferWCOStatus::REJECTED_BY_SANCTION_HIT)
                            <h2>Screening Information Received</h2>
                            <p>Hits identified! Further screening required.</p>
                            <p>Our team will review and update again. We may manually contact you for further information.</p>
                        @elseif ($wcoScreeningStatus === MM\CommonUtilities\Types\RemitfxTransferWCOStatus::CLEARED)
                            <h2>Screening Information Received</h2>
                            <p>Success! The initial checks have been cleared.</p>
                            <p>We will proceed with screening and processing the transaction.</p>
                        @endif
                    </div>
                    @if ($wcoScreeningStatus == MM\CommonUtilities\Types\RemitfxTransferWCOStatus::ADDITIONAL_INFO_REQUIRED)
                        <div style="position:absolute; right:1.5rem; top:3rem;">
                            <a class="btn btn-primary"
                                href="{{ route('transfer.page.wco.form', ['orderId' => $transfer->id]) }}">Take Action</a>
                        </div>
                        <div style="position:absolute; right:1.5rem; bottom:1.5rem;">To avoid order expiry, please complete this task in <span id="countdown" style="color:#467fcf;"></span></div>
                    @endif
                </div>
            </div>
        </div>
        @endif
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <p class="h4">Sender Details</p>
                                @include('partials.label-value', [
                                    'label' => 'Type',
                                    'value' => $transfer->type_of_customer,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Name',
                                    'value' => $transfer->sender_name,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'DOB',
                                    'value' => $transfer->sender_date_of_birth,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'ID Type',
                                    'value' => $transfer->sender_id_type,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'ID No',
                                    'value' => $transfer->sender_id_no,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Nationality',
                                    'value' => $transfer->senderNationality->citizenship ?? null,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Occupation or Business Type',
                                    'value' => $transfer->occupation_or_business_type,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Source Country',
                                    'value' => $transfer->sourceCountry->name ?? null,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Contact No',
                                    'value' => $transfer->sender_contact_no,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Address',
                                    'value' => $transfer->sender_address,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'City',
                                    'value' => $transfer->sender_city,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Country',
                                    'value' => $transfer->senderCountry->name ?? null,
                                ])
                                <hr>
                                <p class="h4">Beneficiary Details</p>
                                @include('partials.label-value', [
                                    'label' => 'Type',
                                    'value' => $transfer->type_of_beneficiary,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Relationship',
                                    'value' => $transfer->readable_relationship,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Name',
                                    'value' => $transfer->beneficiary_name,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'ID Type',
                                    'value' => $transfer->beneficiary_id_type,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'ID No',
                                    'value' => $transfer->beneficiary_id_no,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Address',
                                    'value' => $transfer->beneficiary_address,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Contact No',
                                    'value' => $transfer->beneficiary_contact_no,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'City',
                                    'value' => $transfer->beneficiary_city,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Country',
                                    'value' => $transfer->beneficiaryCountry->name ?? null,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Bank Branch Name',
                                    'value' => $transfer->branch_name,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Bank Branch Code',
                                    'value' => $transfer->branch_code,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'IBAN No.',
                                    'value' => $transfer->iban_no,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Sort Code',
                                    'value' => $transfer->sort_code,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Bank Address',
                                    'value' => $transfer->bank_address,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Electronic Transaction Routing Number',
                                    'value' => $transfer->routing_number,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Account Type',
                                    'value' => $transfer->account_type,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'CLABE',
                                    'value' => $transfer->clabe,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Tax Registration No (CPF)',
                                    'value' => $transfer->tax_registration_number,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Transit No',
                                    'value' => $transfer->transit_number,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Institution No',
                                    'value' => $transfer->institution_number,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Beneficiary Address',
                                    'value' => $transfer->home_address,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Beneficiary City',
                                    'value' => $transfer->home_city,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Beneficiary Postcode',
                                    'value' => $transfer->home_postal_code,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Beneficiary Country',
                                    'value' => $transfer->homeCountry->name ?? null,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Phone Number',
                                    'value' => $transfer->owner_phone_number,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'PIC Name (Beneficiary)',
                                    'value' => $transfer->pic_name,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'CNAPS',
                                    'value' => $transfer->cnaps,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Regency',
                                    'value' => $transfer->regency_code,
                                ])

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <p class="h4">Transfer Details</p>
                                @include('partials.label-value', [
                                    'label' => 'To Amount',
                                    'value' => "$transfer->to_currency $transfer->to_amount",
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Rate',
                                    'value' => $transfer->rate,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'From Amount',
                                    'value' => "$transfer->from_currency $transfer->from_amount",
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Fee',
                                    'value' => "$transfer->fee_currency $transfer->fee_amount",
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Purpose',
                                    'value' => trans("mm-utils::purpose.$transfer->purpose"),
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Source of Fund',
                                    'value' => trans("mm-utils::source-of-funds.$transfer->source_of_fund"),
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Sender Remark',
                                    'value' => $transfer->sender_remark,
                                ])
                                @include('partials.label-value', [
                                    'label' => 'Partner Transaction Id',
                                    'value' => $transfer->partner_transaction_id,
                                ])
                                @component('partials.label-value', ['label' => 'Status'])
                                    @include('transfers.partials.transfer-status')
                                @endcomponent
                                @include('partials.label-value', [
                                    'label' => 'Created At',
                                    'value' => $transfer->local_created_at,
                                ])
                                <hr>
                                <p class="h4">Beneficiary Payout Details</p>
                                @switch($transfer->payout_method)
                                    @case('ACCOUNT_CREDIT')
                                        @include('partials.label-value', [
                                            'label' => 'Bank Name',
                                            'value' => $transfer->bank_name,
                                        ])
                                        @include('partials.label-value', [
                                            'label' => 'Swift Code',
                                            'value' => $transfer->swift_code,
                                        ])
                                        @include('partials.label-value', [
                                            'label' => 'Bank Account Title',
                                            'value' => $transfer->bank_account_title,
                                        ])
                                        @include('partials.label-value', [
                                            'label' => 'Account No',
                                            'value' => $transfer->account_no,
                                        ])
                                        @include('partials.label-value', [
                                            'label' => 'Bank Address',
                                            'value' => $transfer->beneficiary_bank_address,
                                        ])
                                    @break

                                    @case('DIGITAL_WALLET')
                                        @include('partials.label-value', [
                                            'label' => 'Digital Wallet Provider',
                                            'value' => $transfer->digital_wallet_provider,
                                        ])
                                        @include('partials.label-value', [
                                            'label' => 'Digital Wallet ID',
                                            'value' => $transfer->digital_wallet_id,
                                        ])
                                        @include('partials.label-value', [
                                            'label' => 'Digital Wallet Account Title',
                                            'value' => $transfer->digital_wallet_account_title,
                                        ])
                                    @break

                                    @case('CASH_PICKUP')
                                        @if (data_get($cspFields, 'cash_pickup_agent'))
                                            @include('partials.label-value', [
                                                'label' => 'Cash Pickup Agent',
                                                'value' => data_get($cspFields, 'cash_pickup_agent'),
                                            ])
                                        @elseif(data_get($cspFields, 'cash_pickup_location'))
                                            @include('partials.label-value', [
                                                'label' => 'Cash Pickup Location',
                                                'value' => data_get($cspFields, 'cash_pickup_location'),
                                            ])
                                        @endif
                                        @if (data_get($cspFields, 'cash_pickup_security_answer'))
                                            @include('partials.label-value', [
                                                'label' => 'Cash Pickup Security Answer',
                                                'value' => data_get($cspFields, 'cash_pickup_security_answer'),
                                            ])
                                        @endif
                                        @include('partials.label-value', [
                                            'label' => 'Cash Pickup Status',
                                            'value' => data_get($cspFields, 'cash_pickup_status'),
                                        ])
                                        @include('partials.label-value', [
                                            'label' => 'Cash Pickup Description',
                                            'value' => data_get($cspFields, 'cash_pickup_description'),
                                        ])
                                        @if (data_get($cspFields, 'cash_pickup_url'))
                                            <div class="details-list">
                                                <a href="{{ data_get($cspFields, 'cash_pickup_url') }}">Cash Pickup URL</a>
                                            </div>
                                        @endif
                                    @endswitch
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="btn btn-primary ml-auto" href="{{ route('transfer.page.index') }}">
                Back
            </a>
        </div>
        @push('scripts')
            <script type="text/javascript">
                let expiryDateTime = @json($wcoAdditionalFieldsRequestExpiry);
                // Set the date we're counting down to
                var countDownDate = new Date(expiryDateTime).getTime();

                // Update the countdown every 1 second
                var x = setInterval(function() {
                    // Get the current date and time
                    var now = new Date().getTime();

                    // Find the distance between now and the count down date
                    var distance = countDownDate - now;

                    // Calculate the days, hours, minutes and seconds left
                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    // Output the result in an element with id="countdown"
                    document.getElementById("countdown").innerHTML = days + "d " + hours + "h "
                    + minutes + "m " + seconds + "s ";

                    // If the count down is finished, write some text
                    if (distance < 0) {
                        clearInterval(x);
                        document.getElementById("countdown").innerHTML = "EXPIRED";
                    }
                }, 1000);

            </script>
        @endpush
    @stop
