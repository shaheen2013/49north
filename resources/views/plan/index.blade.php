@extends('layouts.main')

@section('title', 'Users')

@section('content1')
    <div class="well-default-trans">
        <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                    <h3>
                        <span class="active-span" id="pending_span">Active Plans </span>
                    </h3>
                </div>
            </div>
            <div class="col-sm-10">

            </div>
            <div class="col-sm-12">
            @if($plan)
                @if(auth()->user()->is_admin == 1)
                <form action="{{ route('plans.update', $plan->id) }}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="form-group">
                        <div class="text_outer">
                            <label for="agreement_file"><i class="fa fa-fw fa-photo"></i> Upload File</label>
                            <input type="file" name="file" class="form-control _input_choose_file">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn-dark contact_btn">Save</button>
                    </div>
                </form>
                @endif
                <iframe src="{{ fileUrl($plan->file) }}" style="width: 100%;"></iframe>
            @else
            <h3>No file has been uploaded yet.</h3>
            <form action="{{ route('plans.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <div class="text_outer">
                        <label for="agreement_file"><i class="fa fa-fw fa-photo"></i> Upload File</label>
                        <input type="file" name="file" class="form-control _input_choose_file">
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn-dark contact_btn">Save</button>
                </div>
            </form>
            @endif
            </div>
        </div>
    </div>
@endsection
