<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>@yield('title', 'Home') - {{ env('APP_NAME') }}</title>

    <!-- Bootstrap  CSS -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Custom styles-->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap core JavaScript -->
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <!-- Bootstrap core JavaScript -->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <!-- Plugin JavaScript -->
    <script src="{{asset('js/jquery.easing.min.js')}}"></script>
    <!-- Custom scripts for this template -->
    {{--<script src="{{asset('js/agency.min.js')}}"></script>--}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
   
    @stack('after-styles')

    <script>
        window.Laravel = {csrfToken: '{{ csrf_token() }}'};
    </script>
</head>
