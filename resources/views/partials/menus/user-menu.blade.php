<div class="dropdown">
    <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
        <span class="ml-2 d-none d-lg-block">
            <span class="text-default">
              {{ auth()->user()->name }}
              @if(auth()->user()->isAdmin())
                  <span class="badge badge-dark ml-2 position-relative">Admin</span>
              @endif
            </span>
        </span>
    </a>
    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
        @include('partials.buttons.logout', ['class' => 'dropdown-item', 'iconClass' => 'dropdown-icon'])
    </div>
</div>
