<li class="nav-item">
    <a href="{{ route('transfer.page.index') }}" class="nav-link @yield('menu.past-transfers')"><i
            class="fe fe-repeat mr-2"></i>Past Transfers</a>
</li>
@if(!auth()->user()->is_xcurrent_user && !auth()->user()->isDomestic() && auth()->user()->setting('status'))
    <li class="nav-item">
        <a href="{{ route('transfer.import.create') }}" class="nav-link @yield('menu.upload')"><i
                class="fe fe-upload mr-2"></i>Upload</a>
    </li>
@endif
<li class="nav-item">
    <a href="{{ action('PartnerSettingController@index') }}" class="nav-link @yield('menu.settings')"><i
            class="fe fe-settings mr-2"></i>Account Settings</a>
</li>
<li class="nav-item">
    @include('partials.buttons.logout', ['class' => 'nav-link d-lg-none', 'iconClass' => 'mr-2'])
</li>

<li class="ml-auto d-flex">
    <div class="nav-item text-dark"
         title="as of {{ \Carbon\Carbon::now(auth()->user()->timezone ?? config('app.timezone')) }}" data-toggle="modal"
         data-target="#rate-calculator">
        <i class="fa fa-lg fa-calculator text-primary"></i>
    </div>
    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow fx-calc-dropdown">
    </div>
    <div class="nav-item ml-3">
        @include('transactions.partials.wallet-summary')
    </div>
</li>
