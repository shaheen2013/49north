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
                        <a class="nav-link active" href="{{ route('edit-profile') }}">My Profile </a>
                    </li>

                    @admin
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('company.index') }}" role="tab">Company</a>
                    </li>
                    @endadmin

                    @admin
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}" role="tab">Admin</a>
                    </li>
                    @endadmin
                    <li class="nav-item">
                        <a class="nav-link" id="benefits-tab" data-toggle="tab" href="#benefits" role="tab"
                           aria-controls="benefits" aria-selected="true">Benefits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="classroom-tab" data-toggle="tab" href="#classroom" role="tab"
                           aria-controls="classroom" aria-selected="true">Classroom</a>
                    </li>
                </ul>
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

            <a class="nav-item nav-link  {{ (request()->is('agreementlist')) ? 'active' : '' }}" id="agreement_list"
               href="{{ url('agreementlist') }}">Agreements</a>

            <a class="nav-item nav-link  {{ (request()->is('mileage/*')) ? 'active' : '' }}" id="agreement_list"
               href="{{ route('mileage.mileage-list') }}">Mileage</a>

            <a class="nav-item nav-link  {{ (request()->is('expense/list')) ? 'active' : '' }}" id="agreement_list"
               href="{{ url('expense/list') }}">Expense</a>

            <a class="nav-item nav-link  {{ (request()->is('maintenance/list')) ? 'active' : '' }}"
               id="maintenance_list" href="{{ url('maintenance/list') }}">Maintenance</a>

            <a class="nav-item nav-link  {{ (request()->is('timeoff/list')) ? 'active' : '' }}" id="timeoff_list"
               href="{{ url('timeoff/list') }}">Time Off</a>

            <a class="nav-item nav-link {{request()->is('paystatement/list') ? 'active' : '' }}" id="nav-statements-tab"
               href="{{url('paystatement/list')}}">Pay Statements</a>

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
