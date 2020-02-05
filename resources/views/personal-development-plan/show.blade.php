@extends('layouts.main')

@section('content1')
    @if($show->comment)
        <div class="well-default-trans">
            <div class="row">
                <div class="col-sm-12">
                    <div class="text-center" style="width: 400px; margin: auto; ">
                        <h5 class="mb-3">
                            <span class="active-span" id="pending_span">{{$show->employee->firstname}} {{$show->employee->lastname}} Personal Development Plan</span>
                        </h5>
                        <div style="width: 100%; display: table; font-weight:500; font-size: 14px" class="mb-4">

                            <span class="float-left">Start Date : {{ date("j F, Y", strtotime($show->start_date)) }}</span>
                            <span class="float-right">End Date : {{date("j F, Y", strtotime($show->end_date)) }}</span>
                        </div>
                        @if(auth()->user()->id == $show->emp_id)
                            <form action="" id="personal_development_update_form">
                                <input type="hidden" id="personal_development_update_id" name='id' value="{{$show->id}}">

                                <div class="text_outer">
                                    <textarea style="height: 100px" class="form-control" placeholder="write here....." name="comment" id="edit_comment"></textarea>
                                </div>

                                <div class="row margin-top-30">
                                    <div class="form-group" style="width:100%;">
                                        <div class="col-md-12 col-sm-12">
                                            <button type="button" onclick="updateComment()" class="btn-dark contact_btn"
                                                    data-form="expences" id="update">Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        @else
                            <div style="width: 100%; display: table; font-weight:500; font-size: 14px" class="mb-4">
                                <span class="float-centre">Description : {{$show->description}}</span>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="well-default-trans">
            <div class="row">
                <div class="col-sm-12">
                    <div class="text-center" style="width: 400px; margin: auto; ">
                        <h5 class="mb-3">
                        <span class="active-span" id="pending_span">{{$show->employee->firstname}} {{$show->employee->lastname}} Personal Development Plan</span>


                        </h5>
                        <div style="width: 100%; display: table; font-weight:400; font-size: 14px" class="mb-4">

                            <span class="float-left">Start Date : {{ date("j F, Y", strtotime($show->start_date)) }}</span>
                            <span class="float-right">End Date : {{date("j F, Y", strtotime($show->end_date)) }}</span>
                        </div>
                        @if(auth()->user()->id == $show->emp_id)
                            <form action="" id="personal_development_create_form">
                                <input type="hidden" id="personal_development_comment_id" name='id' value="{{$show->id}}">

                                <div class="text_outer">
                                    <textarea style="height: 100px" class="form-control" placeholder="write here....." name="comment" id="create_comments"></textarea>
                                </div>


                                <div class="row margin-top-30">
                                    <div class="form-group" style="width:100%;">
                                        <div class="col-md-12 col-sm-12">
                                            <button type="button" onclick="createComment()" class="btn-dark contact_btn"
                                                    data-form="expences" id="create">Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        @else
                            <div style="width: 100%; display: table; font-weight:400; font-size: 14px" class="mb-4">
                                <span class="float-centre">Description : {{$show->description}}</span>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @endif
    <script type="text/javascript">
        let updateRoute = null;
        let route = '@php echo $route; @endphp';
        function createComment() {
            event.preventDefault();

            let id = $('#personal_development_comment_id').val();
            $('#create').attr('disabled', 'disabled');

            $.ajax({
                method: "POST",
                url: route,
                data: new FormData(document.getElementById('personal_development_create_form')),
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

            let id = $('#personal_development_update_id').val();
            $('#update').attr('disabled', 'disabled');

            $.ajax({
                method: "POST",
                url: route,
                data: new FormData(document.getElementById('personal_development_update_form')),
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
