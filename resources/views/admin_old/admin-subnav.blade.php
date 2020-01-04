<div class="col-md-12">
    <nav class="top_tab_details">
        <div class="container-fluid">
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" href="{{ route('agreementlist') }}">Agreement</a>
                <a class="nav-item nav-link nav_expense" id="nav-expense-tab" data-toggle="tab" href="#nav-expense"
                   role="tab" aria-controls="nav-expense" aria-selected="true">Expense Report</a>
                <a class="nav-item nav-link nav_mileage" id="nav-mileage-tab" data-toggle="tab" href="#nav-mileage"
                   role="tab" aria-controls="nav-mileage" aria-selected="false">Mileage Book</a>
                <a class="nav-item nav-link" id="nav-maintenance-tab" data-toggle="tab" href="#nav-maintenance"
                   role="tab" aria-controls="nav-maintenance" aria-selected="false">Tech Maintenance</a>
                <a class="nav-item nav-link" id="nav-time-tab" data-toggle="tab" href="#nav-time" role="tab"
                   aria-controls="nav-time" aria-selected="false">Time Off</a>
                <a class="nav-item nav-link" id="nav-concern_report-tab" data-toggle="tab" href="#nav-concern_report"
                   role="tab" aria-controls="nav-concern_report" aria-selected="false">Report a Concern</a>

                <a class="nav-item nav-link" id="nav-statements-tab" href="{{url('admin/addpaystatement')}}">Pay
                    Statements</a>
            </div>
        </div><!--------------container--------------->
    </nav>
</div>
