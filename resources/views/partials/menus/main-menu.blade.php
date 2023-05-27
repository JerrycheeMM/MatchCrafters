<ul class="nav nav-tabs border-0 flex-column flex-lg-row">
    @switch(auth()->user()->access)
        @case('partner')
        @case('internal_partner')
        @include('partials.menus.by-access.partner')
        @break
        @case('admin')
        @include('partials.menus.by-access.admin')
        @break
    @endswitch
</ul>
