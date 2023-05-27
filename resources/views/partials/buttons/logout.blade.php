<a class="{{ $class ?? '' }}" onclick="document.getElementById('logout-form').submit();">
    <i class="fe fe-log-out {{ $iconClass ?? '' }}"></i> Sign out
    <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
        @csrf
        <button type="submit"></button>
    </form>
</a>
