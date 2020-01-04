
  <nav class="navbar navbar-expand-lg navbar-dark" id="mainNav">
    <div class="container-fluid">
      <a class="navbar-brand js-scroll-trigger logo_se" href="#page-top"><img width="150" src="{{asset('img/logo.jpg')}}" alt="" ></a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fa fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul id="myTab" role="tablist" class="navbar-nav text-uppercase nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true" >My Profile </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="admin-tab" data-toggle="tab" href="#admin" role="tab" aria-controls="admin" aria-selected="true" onclick="get_agreementlist()">Admin</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="benefits-tab" data-toggle="tab" href="#benefits" role="tab" aria-controls="benefits" aria-selected="true">Benefits</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="classroom-tab" data-toggle="tab" href="#classroom" role="tab" aria-controls="classroom" aria-selected="true">Classroom</a>
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
  <div class="col-md-12">
    <nav class="top_tab_details">
                  <div class="container-fluid">
                      <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link" href="{{ route('agreementlist') }}" >Agreement</a>
                        <a class="nav-item nav-link nav_expense" id="nav-expense-tab" data-toggle="tab" href="#nav-expense" role="tab" aria-controls="nav-expense" aria-selected="true">Expense Report</a>
                        <a class="nav-item nav-link nav_mileage" id="nav-mileage-tab" data-toggle="tab" href="#nav-mileage" role="tab" aria-controls="nav-mileage" aria-selected="false" >Mileage Book</a>
                        <a class="nav-item nav-link" id="nav-maintenance-tab" data-toggle="tab" href="#nav-maintenance" role="tab" aria-controls="nav-maintenance" aria-selected="false">Tech Maintenance</a>
                        <a class="nav-item nav-link" id="nav-time-tab" data-toggle="tab" href="#nav-time" role="tab" aria-controls="nav-time" aria-selected="false">Time Off</a>
                        <a class="nav-item nav-link" id="nav-concern_report-tab" data-toggle="tab" href="#nav-concern_report" role="tab" aria-controls="nav-concern_report" aria-selected="false">Report a Concern</a>

                        <a class="nav-item nav-link" id="nav-statements-tab" href="{{url('admin/addpaystatement')}}" >Pay Statements</a>
                      </div>
                  </div><!--------------container--------------->
                </nav>
  </div>
