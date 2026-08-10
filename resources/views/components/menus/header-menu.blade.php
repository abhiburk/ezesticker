@props(['itemClass' => 'mx-2'])
<ul class="navbar-nav ml-auto align-items-lg-center">
    <li class="nav-item {{ $itemClass }} ">
        <a class="nav-link font-weight-normal" href="{{ route('home') }}">
            <i class="bi bi-house"></i> Home
        </a>
    </li>
    @auth
        <li class="nav-item {{ $itemClass }} ">
            @livewire('chat.chat-header-notification')
        </li>
    @endauth
    <li class="nav-item {{ $itemClass }} ">
        <a class="nav-link font-weight-normal" href="{{ route('shop') }}">
            <i class="bi bi-shop"></i> Shop
        </a>
    </li>
    @auth
        <li class="nav-item {{ $itemClass }} ">
            <a class="nav-link font-weight-normal" href="{{ route('referral-program') }}">
                <i class="bi bi-person-plus"></i>
                Referral Program
            </a>
        </li>
        
        <li class="nav-item dropdown {{ $itemClass }} d-none d-lg-block">
            <a class="nav-link font-weight-normal p-1 avtar-rounded rounded-circle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                <x-utils.avtar src="{{ auth()->user()->getUserImageUrl() }}" name="{{ auth()->user()->name }}" width="30" height="30"/>
            </a>
            <x-menus.menu-dropdown/>
        </li>
    @endauth
    
    @guest
        <li class="nav-item {{ $itemClass }} ">
            <a class="nav-link font-weight-normal" href="#" data-toggle="modal" data-target="#authModal">
                <i class="bi bi-box-arrow-in-left"></i> Login
            </a>
        </li>
    @endguest
    {{-- <li class="nav-item message-listing {{ $itemClass }}">
        @livewire('cart.cart-counter')
    </li> --}}
</ul>