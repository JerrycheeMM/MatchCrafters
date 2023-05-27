<li class="nav-item">
    <a href="{{ action('PartnersController@index') }}" class="mr-5 nav-link @yield('menu.partners')"><i
                class="fe fe-users mr-2"></i>Partners</a>
    <a href="{{ action('XCurrentController@index') }}" class="mr-5 nav-link @yield('menu.xcurrent')"><i class="fe fe-users mr-2"></i>XCurrent</a>
    <a href="{{ action('AdminPrefundController@index') }}" class="nav-link @yield('menu.prefunds')"><i
            class="fe fe-download mr-2"></i>Prefunds</a>
</li>
<li class="nav-item">
    @include('partials.buttons.logout', ['class' => 'nav-link d-lg-none', 'iconClass' => 'mr-2'])
</li>

@isset($isPartnerSettingsPage)
<li class="ml-auto d-flex">
    <div class="nav-item text-dark"
         title="as of {{ \Carbon\Carbon::now(auth()->user()->timezone ?? config('app.timezone')) }}" data-toggle="modal"
         data-target="#rate-calculator">
        <i class="fa fa-lg fa-calculator text-primary"></i>
    </div>
    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow fx-calc-dropdown">
    </div>
</li>
@endisset
