<!DOCTYPE html>
<html lang="en">

@include('head')

<body id="page-top">

<!-- Navigation -->
<header class="masthead">
    <div class="logo">
        <div class="container-fluid">
            <img src="{{ asset('img/logow.png') }}" alt="">
        </div>
    </div>
    <img src="{{asset('img/loginbg.jpg')}}" class="bg" alt="">
    <div class="container welcome_login">
        <div class="intro-text">
            <div class="intro-lead-in">Welcome to the</div>
            <div class="intro-heading"><strong>49 North</strong><br>Employee Portal</div>
            <a class=" btn-xl js-scroll-trigger " href="{{route('login')}}">Login</a>
        </div>
    </div>
</header>

</body>

</html>
