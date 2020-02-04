@extends('layouts.main')
@section('content1')

    {{-- @if($show->comment) --}}

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card" style=" margin-top: 25px; ">
                    <div class="card-body">
                        <h2 class="header" style="margin-bottom: 1rem; font-size: 1.5rem; padding : inherit; ">
                            Subject
                            <span class="pull-right">
                                <form action="{{$deleteRoute}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $show->id }}">
                                    <button type="button" class="btn btn-info" onclick="mainance_edit_view_ajax('{{$show->id}}', '{{ $editRoute }}')"> Edit </button>
                                    <button type="submit" href="javascript:void(0);" class="btn btn-danger deleteit">Delete</button>
                                </form>
                            </span>
                        </h2>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <p><strong>Subject</strong>: {{$show->subject}}</p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-12">
                <div class="card" style=" margin-top: 25px; ">
                    <div class="card-body">
                        <h2 class="header" style="margin-bottom: 1rem; font-size: 1.5rem; padding : inherit; ">
                            Description
                        </h2>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <p><strong>Description</strong>: {{$show->description}}</p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            @if($show->comment)

                <div class="col-md-12">
                    <div class="card" style="margin-top: 25px;margin-bottom: 10px;">
                        <div class="card-body">
                            <h2 class="header" style="margin-bottom: 1rem; font-size: 1.5rem; padding : inherit; ">
                                Comment
                            </h2>
                            <form action="" id="maintenance_update_form">
                                <input type="hidden" id="maintenance_update_id" name='id' value="{{$show->id}}">
                                <div class="col-md-12">

                                    <div class="text_outer">
                                        <textarea style="height: 100px" class="form-control" placeholder="write here....." name="comment" id="create_comment"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <button type="button" onclick="update_comment()" class="btn-dark contact_btn"
                                            data-form="expences" id="update" style="margin-bottom: 0px; ">Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            @else

                <div class="col-md-12">
                    <div class="card" style="margin-top: 25px;margin-bottom: 10px;">
                        <div class="card-body">
                            <h2 class="header" style="margin-bottom: 1.5rem; font-size: 1.5rem; padding : inherit; ">
                                Comment
                            </h2>
                            <form action="" id="maintenance_create_form">
                                <input type="hidden" id="maintenance_create_id" name='id' value="{{$show->id}}">
                                <div class="col-md-12">
                                    <div class="text_outer">
                                        <textarea style="height: 100px" class="form-control" placeholder="write here....." name="comment" id="create_comment_add"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <button type="button" onclick="create_comment()" class="btn-dark contact_btn"
                                            data-form="expences" id="update" style="margin-bottom: 0px; ">Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <div id="edit-maintenance-modal" class="modal fade bs-example-modal-lg edit-maintenance-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <!-- modal come on ajax-->
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                        <form class="maintenance1_edit" action="{{ route('maintenance.edit') }}" method="POST">

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        let updateRoute = null;
        let route = '@php echo $route; @endphp';
        function create_comment() {
            event.preventDefault();

            let id = $('#maintenance_create_id').val();
            console.log(id);
            $('#create').attr('disabled', 'disabled');

            $.ajax({
                method: "POST",
                url: route,
                data: new FormData(document.getElementById('maintenance_create_form')),
                dataType: 'JSON',
                processData: false,  // Important!
                contentType: false,
                cache: false,
                success: function (response) {
                    $.toaster({message: 'Created successfully', title: 'Success', priority: 'success'});


                    $('#create').removeAttr('disabled');
                }

            });
        }

        function update_comment() {
            event.preventDefault();
            let id = $('#maintenance_update_id').val();
            console.log(id);
            $('#update').attr('disabled', 'disabled');

            $.ajax({
                method: "POST",
                url: route,
                data: new FormData(document.getElementById('maintenance_update_form')),
                dataType: 'JSON',
                processData: false,  // Important!
                contentType: false,
                cache: false,
                success: function (response) {
                    $.toaster({message: 'Created successfully', title: 'Success', priority: 'success'});


                    $('#update').removeAttr('disabled');
                }

            });
        }
    </script>



@endsection
