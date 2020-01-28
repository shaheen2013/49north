<!DOCTYPE html>
<html lang="en">

@include('head')


<body id="page-top">
<div id="app">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark" id="mainNav">
        <div class="container-fluid">
            <a class="navbar-brand js-scroll-trigger logo_se" href="{{ route('home') }}"><img width="150" src="{{asset('img/logo.jpg')}}" alt=""></a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                    data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                    aria-label="Toggle navigation">
                Menu
                <i class="fa fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <div id="myTabMain">
                    <ul id="myTab" role="tablist" class="navbar-nav text-uppercase nav nav-tabs">

                        <li class="nav-item">
                            <a class="nav-link {{ $activeMenu == 'profile' ? 'active' : '' }}" href="{{ route('edit-profile') }}">My Profile </a>
                        </li>

                        @admin
                        <li class="nav-item">
                            <a class="nav-link {{ $activeMenu == 'company' ? 'active' : '' }}" href="{{ route('company.index') }}" role="tab">Company</a>
                        </li>
                        @endadmin

                        @admin
                        <li class="nav-item">
                            <a class="nav-link {{ $activeMenu == 'admin' ? 'active' : '' }}" href="{{ route('users.index') }}" role="tab">Admin</a>
                        </li>
                        @endadmin
                        <li class="nav-item">
                            <a class="nav-link {{ $activeMenu == 'benefits' ? 'active' : '' }}" href="{{ route('plans.index') }}" role="tab">Benefits</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $activeMenu == 'classroom' ? 'active' : '' }}" href="{{ route('missions.index') }}" role="tab">Classroom</a>
                        </li>
                    </ul>
                </div>
                <div class="pull-right">
                    <ul class="navbar-nav text-uppercase">
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="javascript:void(0)"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <img src="{{asset('img/sign.jpg')}}" alt="" width="24p" >
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>

                    </ul>
                </div>
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
            {{--<a class="nav-item nav-link  {{ (request()->is('home')) ? 'active' : '' }}" id="nav-employee-tab"  href="{{ url('home') }}" aria-controls="nav-employee" aria-selected="true">Employee Information</a>--}}

            @if($activeMenu == 'profile')
            <a class="nav-item nav-link {{ (request()->is('edit-profile')) ? 'active' : '' }}" href="{{ url('edit-profile') }}">Employee Information</a>

            <a class="nav-item nav-link {{ (request()->is('agreementlist')) ? 'active' : '' }}" href="{{ url('agreementlist') }}">Agreements</a>

            <a class="nav-item nav-link {{request()->is('paystatement/list') ? 'active' : '' }}" href="{{url('paystatement/list')}}">Pay Statements</a>

            @if(auth()->user()->is_admin == 0)
            <a class="nav-item nav-link {{ (request()->is('messages')) ? 'active' : '' }}" href="{{ route('messages.index') }}">Report a Concern</a>
            @endif
            @endif

            @if($activeMenu == 'company')
                <a class="nav-item nav-link {{ (request()->is('company')) ? 'active' : '' }}" href="{{ url('company') }}">Company List</a>
            @endif

            @if($activeMenu == 'admin')
            <a class="nav-item nav-link {{ (request()->is('users')) ? 'active' : '' }}" href="{{ route('users.index') }}">Employee List</a>

            <a class="nav-item nav-link {{ (request()->is('expense/list')) ? 'active' : '' }}"href="{{ url('expense/list') }}">Expense Report</a>

            <a class="nav-item nav-link {{ (request()->is('mileage/*')) ? 'active' : '' }}" href="{{ route('mileage.mileage-list') }}">Mileage Book</a>

            <a class="nav-item nav-link {{ (request()->is('maintenance/list')) ? 'active' : '' }}" href="{{ url('maintenance/list') }}">Tech Maintenance</a>

            <a class="nav-item nav-link {{ (request()->is('timeoff/list')) ? 'active' : '' }}" href="{{ url('timeoff/list') }}">Time Off</a>

            <a class="nav-item nav-link {{ (request()->is('messages')) ? 'active' : '' }}" href="{{ route('messages.index') }}">Report a Concern</a>
            @endif

            @if($activeMenu == 'benefits')
                <a class="nav-item nav-link {{ (request()->is('plans')) ? 'active' : '' }}" href="{{ route('plans.index') }}">Plan Overview</a>
                <a class="nav-item nav-link" href="#">Additional Benefits Spending</a>
                <a class="nav-item nav-link" href="#">Meals</a>
            @endif

            @if($activeMenu == 'classroom')
                <a class="nav-item nav-link {{ (request()->is('missions')) ? 'active' : '' }}" href="{{ route('missions.index') }}">49 North Mission</a>
                <a class="nav-item nav-link" href="#">Personal Development Plan</a>
                <a class="nav-item nav-link" href="#">Courses</a>
                <a class="nav-item nav-link {{ (request()->is('journal')) ? 'active' : '' }}" href="{{ route('journal.index') }}">Journal</a>
            @endif

        </div>
    </div><!--------------container--------------->
</nav>

<div class="container-fluid">


    @if ($errors->any())
        <br>
        <div class="alert alert-danger all_errors">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
    @endif
    <div class="ajax-delete-msg" style="display: none">
        <br>
        <div class="alert alert-danger" role="alert">
            You have successfully deleted an item.
        </div>
    </div>
    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(session()->has('alert-' . $msg))
                <br>
                <p class="alert alert-{{ $msg }}">
                    {!! nl2br(session()->get('alert-' . $msg)) !!} <a href="#" class="close" data-dismiss="alert"
                                                                      aria-label="close">&times;</a>
                </p>
            @endif
        @endforeach
    </div>

    @yield('content1')
</div>

<div class="logout-footer fixed-bottom float-right">
    @if (Auth::check())
        <div class="text-right">
            @if (session()->exists('was-admin-id') && session()->exists('was-admin'))
                <a class="btn btn-secondary" style="margin-bottom: 30px; margin-right: 20px;" href="{{ route('force-login',[session()->get('was-admin-id'),'return' => 1]) }}">
                    <small>Return To Admin</small>
                </a>
            @endif
      {{--      <a class="btn btn-primary btn-charcoal" href="{{ route('admin.logout') }}">
                <small>Logout</small>
            </a>--}}
        </div>
    @endif
</div>

{{--<script type="text/javascript" src="{{ asset('js/jquery.inputmask.min.js') }}"></script>--}}
<script>
    const $confirmText = 'Are you sure you want to delete this item?';
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
        }
    });

    $("document").ready(function () {
        setTimeout(function () {
            $("p.alert").remove();
        }, 5000); // 5 secs

        $(".flatpickr").flatpickr({
            altInput: true,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d",
        });
    });

    // Format date
    function formatDate(date) {
        let d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return [year, month, day].join('-');
    }

    const is_admin = parseInt({{ auth()->user()->is_admin }});
    const auth_id = parseInt({{ auth()->id() }});
</script>

<script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin.js') }}"></script>
<script src="{{asset('js/custom_function.js')}}"></script>
<script src="{{asset('js/custom_function_admin.js')}}"></script>
<script src="{{ URL::asset('toaster/jquery.toaster.js') }}"></script>
<script src="{{ URL::asset('assets/jquery-spinner/js/jquery.spinner.js') }}"></script>
<script src="{{asset('flatpicker/js/flatpicker.min.js')}}"></script>
<script src="{{asset('js/pagination.min.js')}}"></script>
@stack('scripts')
@yield('js')

</body>
</html>
