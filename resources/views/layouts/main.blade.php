<!DOCTYPE html>
<html lang="en">

@include('head')

<body id="page-top">
<div id="app">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark" id="mainNav">
        <div class="container-fluid">
            <a class="navbar-brand js-scroll-trigger logo_se" href="{{ route('home') }}"><img width="150"
                                                                                    src="{{asset('img/logo.jpg')}}"
                                                                                    alt=""></a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                    data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                    aria-label="Toggle navigation">
                Menu
                <i class="fa fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul id="myTab" role="tablist" class="navbar-nav text-uppercase nav nav-tabs">

                    <li class="nav-item">
                        <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                           aria-controls="profile" aria-selected="true">My Profile </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}" role="tab">Staff</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="benefits-tab" data-toggle="tab" href="#benefits" role="tab"
                           aria-controls="benefits" aria-selected="true">Benefits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="classroom-tab" data-toggle="tab" href="#classroom" role="tab"
                           aria-controls="classroom" aria-selected="true">Classroom</a>
                    </li>
                </ul>
                <ul class="navbar-nav text-uppercase ">
                    <li class="nav-item">
                    <!--<a class="nav-link js-scroll-trigger" href="#"><img src="{{asset('img/sign.jpg')}}" alt="" width="24p" ></a>-->

                        <a class="nav-link js-scroll-trigger" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>

                </ul>
            </div>
        </div>

    </nav>
</div>

{{--
@if (isset($subnav))
    @include($subnav)
@endif  --}}
        <nav class="top_tab_details">
              <div class="container-fluid">
                  <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-employee-tab" data-toggle="tab" href="#nav-employee" role="tab" aria-controls="nav-employee" aria-selected="true">Employee Information</a>
                    <a class="nav-item nav-link" id="agreement_list" href="{{ route('agreementlist') }}">Agreements</a>
                    <a class="nav-item nav-link" id="nav-statements-tab" data-toggle="tab" href="#nav-statements" role="tab" aria-controls="nav-statements" aria-selected="false">Pay Statements</a>
                  </div>
              </div><!--------------container--------------->
        </nav>

<div class="container-fluid">


    @if ($errors->any())
        <div class="alert alert-danger all_errors">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
    @endif
    <div class="ajax-delete-msg" style="display: none">
        <div class="alert alert-danger" role="alert">
            You have successfully deleted an item.
        </div>
    </div>

    @yield('content1')
</div>

{{--<script type="text/javascript" src="{{ asset('js/jquery.inputmask.min.js') }}"></script>--}}
<script>
    const $confirmText = 'Are you sure you want to delete this item?';
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
        }
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="{{ asset('js/admin.js') }}"></script>

@stack('scripts')

