@extends('layouts.main')
@section('title', 'Maintenance| Single view')
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
                                {{ Form::open(array('route' => 'maintenance.delete', 'method' => 'post', 'id' => 'delete-form')) }}
                                @csrf
                                {!! Form::hidden('id', $show->id) !!}
                                    <button type="button" class="btn btn-info" onclick="maintenanceEditView('{{$show->id}}', '{{ $editRoute }}')"> Edit </button>
                                    <button type="button" onclick="deleteConfirm()" class="btn btn-danger">Delete</button>
                               {{ Form::close() }}
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

            <div class="col-md-12">
                <div class="card" style="margin-top: 25px;margin-bottom: 10px;">
                    <div class="card-body">
                        <h2 class="header" style="margin-bottom: 1rem; font-size: 1.5rem; padding : inherit; ">
                            Comment
                        </h2>
                        {{ Form::open(array('id' => 'maintenance_form')) }}
                        <div class="col-md-12">
                            <div class="text_outer">
                                {!! Form::textarea('comment', null, ['class' => 'form-control', 'placeholder' => 'write here.....', 'style' => 'height: 100px']) !!}
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <button type="button" onclick="{{ $show->comment ? 'updateComment' : 'createCommentNew' }}()" class="btn-dark contact_btn" data-form="expences" style="margin-bottom: 0px; ">Save</button>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="edit-maintenance-modal" class="modal fade bs-example-modal-lg edit-maintenance-modal" tabindex="-1"
         role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <!-- modal come on ajax-->
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                        {{ Form::open(array('route' => 'maintenance.edit', 'method' => 'post', 'class' => 'maintenance1_edit')) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        let updateRoute = null;
        let route = '@php echo $route; @endphp';
        function createCommentNew() {
            event.preventDefault();
            $('#create').attr('disabled', 'disabled');

            $.ajax({
                method: "POST",
                url: route,
                data: new FormData(document.getElementById('maintenance_form')),
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

        function updateComment() {
            event.preventDefault();
            $('#update').attr('disabled', 'disabled');
            $.ajax({
                method: "POST",
                url: route,
                data: new FormData(document.getElementById('maintenance_form')),
                dataType: 'JSON',
                processData: false,  // Important!
                contentType: false,
                cache: false,
                success: function (response) {
                    $.toaster({message: 'updated successfully', title: 'Success', priority: 'success'});
                    $('#update').removeAttr('disabled');
                }
            });
        }

        function deleteConfirm() {
            swal({
                title: "Delete?",
                text: "Please ensure and then confirm!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: !0
            }).then(function (e) {
                if (e.value === true) {
                    $('#delete-form').submit();
                } else {
                    e.dismiss;
                }
            }, function (dismiss) {
                return false;
            })
        }
    </script>
@endsection
