<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
@csrf
<div class="row">
    <div class="col-md-6 col-sm-6">
        <div class="text_outer">
            <label for="name" class="">Subject</label>
            <input type="text" id="name" name="subject" class="form-control" value="{{ $maintanance->subject  }}">
        </div>
    </div>
    <div class="col-md-6 col-sm-6">
        <div class="text_outer">
            <label for="name" class="">Website</label>
            <select class="select_status form-control" name="website">
                <option>Select</option>
                <option value="Website1" {{ $maintanance->website == 'Website1' ? 'selected' : '' }}>Website1</option>
                <option value="Website2" {{ $maintanance->website == 'Website2' ? 'selected' : '' }}>Website2</option>
            </select>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12">
        A brief description of your ticket
        <div class="text_outer">
            <label for="name" class="">Description</label>
            <input type="text" id="name" name="description" class="form-control" value="{{ $maintanance->description  }}">
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-6 col-sm-6">
        <div class="text_outer">
            <label for="name" class="">Priority</label>
            <select class="select_status form-control" name="priority">
                <option selected disabled>Select</option>
                <option value="1" {{ $maintanance->priority == 1 ? 'selected' : '' }}>Low</option>
                <option value="2" {{ $maintanance->priority == 2 ? 'selected' : '' }}>Normal</option>
                <option value="3" {{ $maintanance->priority == 3 ? 'selected' : '' }}>Critical</option>
            </select>
        </div>
    </div>
    <div class="col-md-6 col-sm-6">
        <div class="text_outer">
            <label for="name" class="">Category</label>
            <select class="select_status form-control" name="category">
                <option>Select</option>
                @foreach ($category as $category_ex_report) { ?>
                <option value="{{ $category_ex_report->id  }}" {{ $category_ex_report->id == $maintanance->category ? 'selected' : '' }}>{{ $category_ex_report->categoryname  }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="text_outer">
            <label for="name" class="">Employee</label>
            <select class="select2 select_status form-control" name="user[]" multiple>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $maintanance->users->contains('id', $user->id) ? 'selected' : '' }}>{{ $user->employee_details->firstname }} {{ $user->employee_details->lastname }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<hr>
<div class="row margin-top-30">
    <div class="form-group" style="width:100%;">
        <div class="col-md-12 col-sm-12">
            <input type="hidden" name="_token" value="{{ csrf_token()  }}">
            <input type="hidden" name="id" value="{{ $maintanance->id  }}">
            <input type="hidden" name="emp_id" value="{{ auth()->user()->id }}">
            <button type="submit" class="btn-dark contact_btn">Save</button>
            <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> Return to Maintenance</span>
        </div>
    </div>
</div>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script !src="">
    $('.select2').select2();
</script>
