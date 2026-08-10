<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeSidebarNav()">&times;</a>
    @auth
        <div class="d-flex mx-4 py-2 align-items-center">
            <x-utils.avtar src="{{ auth()->user()->getUserImageUrl() }}" name="{{ auth()->user()->name }}" width="30" height="30"/>
            <span class="mx-2">
                {{ auth()->user()->name }}
            </span>
        </div>
    @else
        <a href="{{ route('shop') }}" class="nav-item mx-4 btn btn-warning text-dark shadow-none">Shop Now</a>
    @endauth
    <div class="dropdown-divider my-3"></div>
    <x-menus.header-menu itemClass="mx-4"/>
</div>
  
<!-- Navigation -->
<nav class="navbar navbar-expand-lg shadow-sm navbar-light bg-white" id="mainNav" style="z-index: 12"> 
    <div class="container d-flex justify-content-between align-items-center">
        <button class="navbar-toggler navbar-toggler-right border-0 btn collapsed shadow-none" type="button"
            data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
            aria-label="Toggle navigation" onclick="openSidebarNav()" id="open-sidebar-nav">
            <i class="bi bi-list"></i>
        </button>
        <a class="navbar-brand" href="{{ route('home') }}">
            {{-- <img src="{{ url('frontend/img/ezesticker-logo-icon.png') }}" alt="{{ env('APP_NAME') }}" width="25"> --}}
            <img src="{{ url('frontend/img/ezesticker-logo.png') }}" alt="{{ env('APP_NAME') }}" width="125">
        </a>
        <div>
            <div class="d-lg-none d-sm-block position-relative">
                @auth
                    <a class="nav-link font-weight-normal p-1 avtar-rounded rounded-circle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                        {{-- <span class="header-user" data-letters="{{ Helper::firstLetter(auth()->user()->name) }}" style="font-size:12px;"></span> --}}
                        <x-utils.avtar src="{{ auth()->user()->getUserImageUrl() }}" name="{{ auth()->user()->name }}" width="30" height="30"/>
                    </a>
                @else 
                    <a href="{{ route('login') }}" class="btn btn-outline-warning shadow-none">JoIn</a>
                @endauth
                <x-menus.menu-dropdown/>
            </div> 
        </div>
        <div class="collapse navbar-collapse text-center" id="navbarResponsive">
            <x-menus.header-menu/>
        </div>
    </div>
</nav>

@guest
    <!-- Auth Modal -->
    <div class="modal fade" id="authModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="authLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 justify-content-between"> 
                    <h5 class="modal-title font-weight-bold" id="productPriceLabel">Login/Register</h5>
                    <button type="button" class="close m-0 p-0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @livewire('auth.login-form')
                    <p class="text-muted text-center my-3">
                        <small>We 'll register your account if we do not find entered phone number.</small>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endguest

@push('js')
    <script>
        function copyReferral(_this) {
            /* Get the text field */
            var copyText = document.getElementById("myInput");

            /* Select the text field */
            copyText.select();
            copyText.setSelectionRange(0, 99999); /* For mobile devices */

            /* Copy the text inside the text field */
            document.execCommand("copy");
            $(_this).addClass('btn-outline-success').text('Copied !');
        } 

        var isOpen = false;
        function openSidebarNav() {
            $('#page-overlay').addClass('page-overlay');
            $('#mySidenav').css('left', '0');
            $('body').addClass('position-fixed');
            setTimeout(() => { isOpen = true; }, 100);
        }

        function closeSidebarNav() {
            $('#page-overlay').removeClass('page-overlay');
            $('#mySidenav').css('left', '-300px');
            $('body').removeClass('position-fixed');
            isOpen = false;
        } 

        // when clicked apart from open sidebar close the sidebar
        function hideSidebar(e){
            if(e.target.id !== "mySidenav" && e.target.id !== "" && isOpen){
                closeSidebarNav();
            }
        }
        document.addEventListener("click", hideSidebar);
    </script>
@endpush
@push('css')
    <style>
        .navbar-toggler-right{
            font-size: 30px !important;
        }
        .dropdown-menu {
            min-width: 18rem;
        }
        .header-user::before {
            background: #ffc107;
            color: black;
            font-weight: 600
        }

        .avtar-rounded:hover, .avtar-rounded:focus{
            outline: 0;
            box-shadow: 0 0 0 .2rem rgba(0,123,255,.25);
        }
    </style>
@endpush
