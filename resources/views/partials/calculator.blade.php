<div id="rate-calculator" class="modal fade" aria-hidden="true" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <fx-calculator id="fx-calculator" class="col-12 fx-calculator" :from-currency="fromCurrency" :default-to-currency="defaultToCurrency" :available-to-currencies="availableToCurrencies" :partner-id="partnerId">
                </fx-calculator>
            </div>
        </div>
    </div>
</div>

@php
    $user = auth()->user()->access === 'admin' ? $partner : request()->user();
    $partnerId = $user->id;
    $fromCurrency = $user->balance_currency;
    $availableToCurrencies = json_encode($user->enabledPartnerCurrencies->pluck('to_currency'));
@endphp

@push('mixins')
    <script>
        window.App.mixins.push({
            data: function () {
                return {
                    partnerId: '{!! $partnerId !!}',
                    fromCurrency: '{!! $fromCurrency !!}',
                    availableToCurrencies: {!! $availableToCurrencies !!},
                    defaultToCurrency: '{!! $user->enabledPartnerCurrencies()->first()->to_currency ?? null !!}',
                }
            }
        });
    </script>
@endpush
