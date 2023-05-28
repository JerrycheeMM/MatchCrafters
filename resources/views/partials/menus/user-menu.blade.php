<div class="dropdown">
    <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
        <span class="ml-2 d-none d-lg-block">
            <span class="text-default">
              {{ auth()->user() ? auth()->user()->name : null }}
            </span>
        </span>
    </a>

    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
        <i class="fe fe-log-out {{ $iconClass ?? '' }}"></i> Sign out
        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
            @csrf
            <button type="submit"></button>
        </form>
    </div>
</div>
