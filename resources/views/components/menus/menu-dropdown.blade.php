@auth
    <div class="dropdown-menu dropdown-menu-right shadow-lg" aria-labelledby="navbarDropdown">
        <div class="d-flex dropdown-item py-2 align-items-center">
            <x-utils.avtar src="{{ auth()->user()->getUserImageUrl() }}" name="{{ auth()->user()->name }}" width="30" height="30"/>
            <span class="mx-2">
                {{ auth()->user()->name }}
            </span>
        </div>
        <div class="dropdown-divider"></div>
        @foreach (Helper::getProfileRoute() as $item)
            <a class="dropdown-item py-2" href="{{ route('account.'.$item['route']) }}"> 
                <i class="bi {{ $item['icon'] }}"></i> 
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
        <div class="dropdown-divider"></div>
        @role('Admin')
            <a class="dropdown-item py-2" target="_blank" href="{{ route('dashboard') }}">
                <i class="bi bi-speedometer"></i> Admin Dashboard
            </a>
            <a class="dropdown-item py-2" target="_blank" href="https://help.ezesticker.com?email={{ auth()->user()->email }}">
                <i class="bi bi-bug"></i> Ezesticker Help
            </a>
        @endrole 
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="dropdown-item py-2">
                <i class="bi bi-box-arrow-right"></i> Sign Out
            </button>
        </form>
    </div>
@endauth