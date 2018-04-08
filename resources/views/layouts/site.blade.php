<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Mirobmena</title>
    <link rel="stylesheet" href="{{ asset('css/general.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/panel.css') }}">
    <link rel="stylesheet" href="{{ asset('js/framework/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    {{--<link rel="stylesheet" href="js/components/validation/formValidation.min.css">--}}
    {{--<script src="js/framework/jquery/jquery-2.1.4.min.js"></script>--}}
    {{--<script src="js/framework/bootstrap/js/bootstrap.min.js"></script>--}}
    {{--<script src="js/components/validation/formValidation.min.js"></script>--}}
    {{--<script src="js/validation.js"></script>--}}
    {{--<script src="js/main.js"></script>--}}

</head>
<body>

@yield('content')

    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>
</html>