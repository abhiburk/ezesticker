<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ezesticker:: @yield('title')</title>
    <!-- Bootstrap core CSS -->
    {{-- <link href="{{ url('frontend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="wrapper">
        <img src="{{ url('frontend/img/ezesticker-logo.png') }}" alt="Ezesticker" width="125">
        @yield('content')
    </div>
    <style>
        body {
            background: #e7e7e7;
            color: #fff;
        }
    
    
        @keyframes fadeIn {
            from {
                top: 20%;
                opacity: 0;
            }
    
            to {
                top: 100;
                opacity: 1;
            }
    
        }
    
        @-webkit-keyframes fadeIn {
            from {
                top: 20%;
                opacity: 0;
            }
    
            to {
                top: 100;
                opacity: 1;
            }
    
        }
    
        .wrapper {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            -webkit-transform: translate(-50%, -50%);
            animation: fadeIn 500ms ease;
            -webkit-animation: fadeIn 500ms ease;
            text-align: center;
            width: 100%;
        }
    
        h1 {
            font-size: 50px;
            font-family: 'Poppins', sans-serif;
            margin-bottom: 0;
            line-height: 1;
            font-weight: 700;
            color: black;
            text-align: center;
        }
    
        .dot {
            color: #ffc000;
        }
    
        p {
            text-align: center;
            font-family: 'Muli', sans-serif;
            font-weight: normal;
            color: black;
        }
    
        .icons {
            text-align: center;
            margin-top: 50px;;
        }
    
        .icons i {
            color: #00091B;
            background: #fff;
            height: 15px;
            width: 15px;
            padding: 13px;
            margin: 0 10px;
            border-radius: 50px;
            border: 2px solid #fff;
            transition: all 200ms ease;
            text-decoration: none;
            position: relative;
        }
    
        .icons i:hover,
        .icons i:active {
            color: #000;
            background: none;
            cursor: pointer !important;
            transform: scale(1.2);
            -webkit-transform: scale(1.2);
            text-decoration: none;
            border-color: #fff;
            background-color: #ffc000;
    
        }

        @media (max-width: 786px) {
            h1 {
                font-size: 40px;
            }
        }
    </style>
</body>
</html>