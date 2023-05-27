@extends('layouts.partner')

@section('title', 'RemitFX - Create Transfers Form')

@section('content')
    <div class="container">
        @component('partials.page-header', [
            'title' => 'New Transfer Form',
        ])
        @endcomponent
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('transfer.page.store') }}" method="post">
            {{ csrf_field() }}

            <p><strong>Transfer Details</strong></p>
            <hr class="mt-2 mb-2">
            <div class="form-row mb-5">
                <form-select-field name="Currency to Disburse" attribute="to_currency" class="col-md-6" :required="true"
                                   :initial-value="old"
                                   :options="currencies"></form-select-field>
                <form-text-field name="Amount To" attribute="to_amount" class="col-md-6" :required="true"
                                 :initial-value="old"
                                 type="number"
                                 step="0.01"
                ></form-text-field>

                <form-select-field name="Purpose"
                                   attribute="purpose"
                                   :options-if="purposes"
                                   class="col-md-6"
                                   :required="true"
                                   :initial-value="old"
                                   help="Please select Sender Type before selecting purpose"
                ></form-select-field>
                <form-select-field name="Source of Fund"
                                   attribute="source_of_fund"
                                   :options="source_of_funds"
                                   class="col-md-6" :required="true"
                                   :initial-value="old"></form-select-field>
                <form-text-field name="Sender Remark" attribute="sender_remark" class="col-md-6" :required="true"
                                 :initial-value="old"></form-text-field>
                <form-text-field name="Partner Transaction Id" attribute="partner_transaction_id"
                                 class="col-md-6" :initial-value="old"></form-text-field>
            </div>

            <p><strong>Sender Details</strong></p>
            <hr class="mt-2 mb-2">
            <div class="form-row mb-5">
                <form-select-field name="Sender Type" attribute="type_of_customer"
                                   :options="customer_types"
                                   class="col-md-6" :required="true" :initial-value="old"></form-select-field>
                <form-text-field name="Name" attribute="sender_name" class="col-md-6" :required="true"
                                 :initial-value="old"></form-text-field>
                <form-date-field name="DOB"
                                 attribute="sender_date_of_birth"
                                 class="col-md-6" :required="true"
                                 :visible-if="dobVisibleIf"
                                 :initial-value="old"></form-date-field>
                <form-select-field name="ID Type" attribute="sender_id_type"
                                   class="col-md-6" :required="true" :initial-value="old"
                                   :visible-if="[outboundCondition]"
                                   :options-if="sender_id_type_options"></form-select-field>
                <form-text-field name="ID No" attribute="sender_id_no" class="col-md-6" :required="true"
                                 :initial-value="old"></form-text-field>
                <form-select-picker-field name="Nationality"
                                          attribute="sender_nationality"
                                          :options="nationalities"
                                          :visible-if="[outboundCondition]"
                                          class="col-md-6" :required="true"
                                          :initial-value="old"></form-select-picker-field>
                <form-text-field name="Occupation / Nature of Business" attribute="sender_occupationnature_of_business"
                                 class="col-md-6"
                                 :required="true"
                                 :visible-if="[outboundCondition]"
                                 :initial-value="old"></form-text-field>
                <form-select-picker-field name="Source Country" attribute="source_country"
                                          :options-if="source_country"
                                          class="col-md-6" :required="true"
                                          :initial-value="old"></form-select-picker-field>
                <form-text-field name="Contact No" attribute="sender_contact_no"
                                 :visible-if="[outboundCondition]"
                                 class="col-md-6" :required="true"
                                 :initial-value="old"></form-text-field>
                <form-text-field name="Address" attribute="sender_address"
                                 class="col-md-6"
                                 :required="true"
                                 :visible-if="[outboundCondition]"
                                 :initial-value="old"></form-text-field>
                <form-text-field name="City" attribute="sender_city"
                                 :visible-if="[outboundCondition]"
                                 class="col-md-6" :required="true"
                                 :initial-value="old"></form-text-field>
                <form-select-picker-field name="Country" attribute="sender_country"
                                          :options="countries"
                                          :visible-if="[outboundCondition]"
                                          class="col-md-6" :required="true"
                                          :initial-value="old"></form-select-picker-field>
            </div>
            <p><strong>Beneficiary Details</strong></p>
            <hr class="mt-2 mb-2">
            <div class="form-row mb-5">
                <form-select-field name="Beneficiary Type" attribute="type_of_beneficiary"
                                   :options="customer_types"
                                   class="col-md-6" :required="true" :initial-value="old"
                ></form-select-field>
                <form-select-field name="Relationship"
                                   attribute="relationship"
                                   :options-if="relationships"
                                   class="col-md-6" :required="true" :initial-value="old"
                ></form-select-field>
                <form-text-field name="Name" attribute="beneficiary_name" class="col-md-6" :required="true"
                                 :initial-value="old"></form-text-field>
                <form-select-field name="ID Type"
                                   attribute="beneficiary_id_type"
                                   :visible-if="[outboundCondition]"
                                   class="col-md-6" :required="true" :initial-value="old"
                                   :options-if="beneficiary_id_type_options"></form-select-field>
                <form-text-field name="ID No" attribute="beneficiary_id_no" :required="required_beneficiary_id_no"
                                 class="col-md-6" :initial-value="old"></form-text-field>
                <form-text-field name="Contact No" attribute="beneficiary_contact_no"
                                 :visible-if="[outboundCondition]"
                                 class="col-md-6" :required="true"
                                 :initial-value="old"></form-text-field>
                <form-text-field name="Address"
                                 :visible-if="[outboundCondition]"
                                 attribute="beneficiary_address"
                                 class="col-md-6" :required="true"
                                 :initial-value="old"></form-text-field>
                <form-text-field name="City"
                                 :visible-if="[outboundCondition]"
                                 attribute="beneficiary_city"
                                 class="col-md-6" :required="true"
                                 :initial-value="old"></form-text-field>
                <form-select-field name="Beneficiary Country"
                                   attribute="beneficiary_country"
                                   :options-if="beneficiaryCountryOptions"
                                   class="col-md-6" :required="true"
                                   :initial-value="old"></form-select-field>
                <component v-for="field in additional" class="col-md-6" :required="true" :initial-value="old"
                           v-bind:key="field.attribute"
                           :is="'form-' + field.component + '-field'"
                           v-bind="field"></component>
            </div>
            <p><strong>Beneficiary Bank Details</strong></p>
            <hr class="mt-2 mb-2">
            <div class="form-row mb-5">
                <form-select-field name="Bank Name" attribute="bank_name" class="col-md-6" :required="true"
                                   :initial-value="old"
                                   :options-if="banks"></form-select-field>
                <form-text-field name="Swift Code"
                                 :visible-if="[outboundCondition]"
                                 attribute="swift_code"
                                 class="col-md-6" :required="true"
                                 :initial-value="old"></form-text-field>
                <form-text-field name="Bank Account Title"
                                 :visible-if="[outboundCondition]"
                                 attribute="bank_account_title"
                                 class="col-md-6" :required="true"
                                 :initial-value="old"></form-text-field>

                <form-text-field name="Account No" attribute="account_no" class="col-md-6" :required="true"
                                 :initial-value="old"></form-text-field>

                <form-text-field name="Bank Address"
                                 :visible-if="[outboundCondition]"
                                 attribute="beneficiary_bank_address"
                                 class="col-md-6" :required="true"
                                 :initial-value="old"></form-text-field>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@stop

@push('mixins')
    <script>
        window.App.mixins.push({
            data: function () {
                return {
                    type_of_beneficiary: '',
                    to_currency: '',
                    old: {!! old() ? json_encode(old()) : '{}' !!},
                    banks: {!! $banks !!},
                    currencies: {!! $currencies !!},
                    business_customer_type: '{{ MM\CommonUtilities\Types\CustomerType::BUSINESS }}',
                    customer_types: {!! json_encode(MM\CommonUtilities\Types\CustomerType::LIST) !!},
                    nationalities: {!! $nationalities !!},
                    countries: {!! $countries !!},
                    relationships: @json($relationships),
                    purposes: @json($purposes),
                    beneficiary_id_type_options: @json($beneficiaryIdTypeOptions),
                    sender_id_type_options: @json($senderIdTypeOptions),
                    outboundCondition: {"conditions":[{"attribute":"to_currency", "values": {!! $outboundCurrencies !!}}]},
                    dobVisibleIf: [{"conditions":[{"attribute":"to_currency", "values": {!! $outboundCurrencies !!}}, {attribute: 'type_of_customer', values: ['{{ MM\CommonUtilities\Types\CustomerType::INDIVIDUAL }}']}]}],
                    outbound_currencies: {!! $outboundCurrencies !!},
                    additional: {!! json_encode($additional) !!},
                    beneficiaryCountryOptions: {!! json_encode($beneficiaryCountryOptions) !!},
                    source_of_funds: {!! json_encode($sourceOfFunds) !!},
                    source_country: {!! json_encode($sourceCountry) !!},
                };
            },
            mounted() {
                bus.$on(`type_of_beneficiary-value-change`, value => {
                    this.type_of_beneficiary = value;
                })
                bus.$on(`to_currency-value-change`, value => {
                    this.to_currency = value;
                })
            },
            computed: {
                required_beneficiary_id_no() {
                    return this.outbound_currencies.includes(this.to_currency);
                }
            }
        });
    </script>
@endpush
