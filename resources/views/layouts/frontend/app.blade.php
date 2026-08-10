<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="57x57" href="favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-env" content="{{ env('APP_ENV') }}">
    @auth
        <meta name="auth-user-id" content="{{ auth()->user()->id }}">
    @endauth
    @isset(request()->user_id)
        <meta name="request-user-id" content="{{ Helper::decodeId(request()->user_id) }}">
    @endisset
    <meta name="description" content="Ezesticker provides smart QR stickers for your vehicles,pets and belongings. We are building a community to make your essentials safe through are ezestickers.">
    <meta name="keywords" content="QR Sticker,Ezesticker,Ezestickers,Smart Stickers,Smart QR Sticker,Virtual QR Sticker">
    <meta property="og:title" content="Ezesticker:: Your Smart & Virtual Assistance" />
    <meta property="og:description" content="Ezesticker provides smart QR stickers for your vehicles,pets and belongings. We are building a community to make your essentials safe through are ezestickers." />
    <meta property="og:url" content="{{url('')}}" />
    <meta property="og:image" content="{{ url('frontend/img/ezesticker-logo-landscape.jpg') }}" />
    <base href="{{ url('') }}">
    <meta name="facebook-domain-verification" content="tc0hlq8s8u24mcf3twv4zdjjzjecp6" />
    <title>{{ config('app.name', 'Smart Sticks') }} :: @yield('title')</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ url('frontend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="{{ url('frontend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('frontend/vendor/simple-line-icons/css/simple-line-icons.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ url('frontend/css/new-age.css') }}" rel="stylesheet">
    <link href="{{ url('frontend/css/custom.css') }}" rel="stylesheet">
    <link href="{{ url('frontend/css/loading-line.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    @livewireStyles
    @if (env('APP_ENV') == 'production')

        {{-- Google Analytics from abhiburk account --}}
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-77Z0FXVLH3"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-77Z0FXVLH3');
        </script>

        <!-- Facebook Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '313610967165117');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=313610967165117&ev=PageView&noscript=1"
        /></noscript>
        <!-- End Facebook Pixel Code -->
    @endif
    @stack('head')
</head>
<body>
    <!-- Messenger Chat Plugin Code -->
    <div id="fb-root"></div>

    <!-- Your Chat Plugin code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "108481641331458");
      chatbox.setAttribute("attribution", "setup_tool");

      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v11.0'
        });
      };

      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>
    <!-- PAGE LOADER : PLACE RIGHT AFTER BODY TAG -->
    <div class="page-loader">
        <div class="loading">
            <div class="text-center">
                <img src="{{ url('frontend/img/ezesticker-logo-icon.png') }}" alt="Ezesticker" width="50" style="opacity: 0.3;">
                <div class="loading_line_wrapper">
                    <div class="loading_line">
                        <div class="loading_line_inner loading_line_inner--1"></div>
                        <div class="loading_line_inner loading_line_inner--2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- PAGE LOADER END : PLACE RIGHT AFTER BODY TAG -->
    @if (env('APP_ENV') == 'production')
        <!-- Google Tag Manager (noscript) -->
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PQQ3MN4"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>
        <!-- End Google Tag Manager (noscript) -->
    @endif
    <div id="page-top">
        <div id="wrapper">
            <div id="content-wrapper" class="d-flex flex-column" style="min-height: 100vh;">
                @include('layouts.frontend.app_header')
                <div id="content">
                    @yield('content')
                </div>
                @include('layouts.frontend.app_footer')
            </div>
        </div>
    </div>
    <div id="page-overlay"></div>
    <!-- Bootstrap core JavaScript -->
    <script src="{{ url('frontend/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ url('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Plugin JavaScript -->
    <script src="{{ url('frontend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for this template -->
    <script src="{{ url('frontend/js/new-age.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js" integrity="sha512-LGXaggshOkD/at6PFNcp2V2unf9LzFq6LE+sChH7ceMTDP0g2kn6Vxwgg7wkPP7AAtX+lmPqPdxB47A0Nz0cMQ==" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ url('frontend/js/pushjs/push.min.js') }}"></script>
    <script src="{{ url('frontend/js/pushjs/serviceWorker.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    @stack('css')
    @livewireScripts
    @stack('js')
    
    {{-- Razor Pay Script Start --}}
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        window.addEventListener('make-razorpay', e => {
            var options = {
                "key": "{{ env('RAZOR_KEY') }}", // Enter the Key ID generated from the Dashboard
                "amount": e.detail.amount, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                "currency": "INR",
                "order_id": e.detail.razorpay_order_id, //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                "callback_url": "{{ route('razorpay.response') }}",
                "modal": {
                    "confirm_close": true,
                    "ondismiss": function(){
                        window.livewire.emit('handleRazorPayError', e.detail.razorpay_order_id); // listen in CheckoutSidebar.php
                    }
                }
            };
            var rzp1 = new Razorpay(options);
            rzp1.open();
            rzp1.on('payment.failed', function (response){
                window.livewire.emit('handleRazorPayError', response); // listen in CheckoutSidebar.php
            });
        });
    </script>
    {{-- Razor Pay Script End --}}

    <script type="application/javascript">
        $(function () {
            $('.modal').on('shown.bs.modal', function() { 
                $('.navbar-collapse').collapse('hide');
            });
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="popover"]').popover();
        })
        $(window).on('load',function(){
            setTimeout(function(){ // allowing 3 secs to fade out loader
                $('.page-loader').fadeOut('slow');
            },900);
        });
        document.addEventListener('DOMContentLoaded', function () {
            window.livewire.on('alert', (type, message, title = '') => {
                toastr[`${type}`](message, title);
            });

            window.livewire.on('close-modal', (id) => {
                $(id).modal('hide');
            });

            window.livewire.on('redirect', (url, timeout = 1000, target = false) => {
                setTimeout(() => {
                    if(target){
                        window.open(url, '_blank');
                    }
                    window.location = url;
                }, timeout);
            });

            window.livewire.on('urlChange', (url) => {
                history.pushState(null, null, url);
            }); 
        });

    </script>
    @auth
        <script src="{{ url('frontend/js/chat.js') }}"></script>
        @if (env('APP_ENV') != 'production')
            <script>
                Pusher.logToConsole = true; 
            </script>
        @endif
    @endauth
</body>
</html>
