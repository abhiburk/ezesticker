<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="{{ url('') }}">

    <title>{{ config('app.name', 'Smart Sticks') }} :: @yield('title')</title>

    <link href="{{ url('backend/css/custom.css') }}" rel="stylesheet" />
    <link href="{{ url('backend/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ url('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    {{-- @toastr_css --}}
    @livewireStyles
</head>
<body>

    <div id="wrapper">
        @include('layouts.backend.app_sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                @include('layouts.backend.app_header')
                @yield('content')
            </div>
            <!-- End of Main Content -->
            @include('layouts.backend.app_footer')
        </div>
        <!-- End of Content Wrapper -->
    </div>

    @stack('css')
    <script src="{{ url('backend/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ url('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ url('backend/js/sb-admin-2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/js/all.min.js" integrity="sha512-UwcC/iaz5ziHX7V6LjSKaXgCuRRqbTp1QHpbOJ4l1nw2/boCfZ2KlFIqBUA/uRVF0onbREnY9do8rM/uT/ilqw==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/26.0.0/classic/ckeditor.js"></script>

    <script type="application/javascript">
        
        $(function(){
            
            $('.custom-file input').change(function (e) {
                var files = [];
                for (var i = 0; i < $(this)[0].files.length; i++) {
                    files.push($(this)[0].files[i].name);
                }
                $(this).next('.custom-file-label').html(files.join(', '));
            });

            $('.select2').select2({
                width:'100%'
            });

            $('.confirm-delete').click(function(){
                if(confirm('Are you sure?')){
                    $(this).parents('.delete-form').submit();
                }
            });

            ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            } );
            
        });

    </script>

    
    @stack('js')
    {{-- @toastr_js
    @toastr_render --}}
    @livewireScripts

    <script type="application/javascript">
            
        window.livewire.on('alert', (type, message, title = '') => {
            toastr[`${type}`](message, title);
        });

        window.livewire.on('close-modal', (id) => {
            $(id).modal('hide');
        });
        
    </script>
</body>
</html>
