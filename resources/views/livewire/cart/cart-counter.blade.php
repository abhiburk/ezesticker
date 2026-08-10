<div class="widget-header position-relative">
    <a href="{{ route('shop.cart') }}" class="nav-link">
        <div class="icon">
            <i class="bi bi-cart"></i>
            <span class="d-md-block d-lg-none">Cart</span> 
            <span class="badge badge-danger badge-pill ">{{ Cart::getContent()->count() }}</span>
            {{-- <span class="notify md-inline-block d-none">{{ Cart::getContent()->count() }}</span> --}}
        </div>
    </a>
</div>
