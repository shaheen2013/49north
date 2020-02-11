@extends('layouts.main',['activeMenu' => 'classroom'])
@section('title', 'Edit Course')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.classroom.index',['c' => $classroom->company]) }}">Courses</a></li>
@endsection

@section('content1')

    {{ Form::model($classroom,['url' => route('admin.classroom.store'),'files' => true]) }}
    {{ Form::hidden('id') }}
    {{ Form::hidden('company') }}

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col col-sm-4">
                    {{ Form::label('subject') }}
                    {{ Form::select('subject',[0 => '-- New Subject'] + \App\Models\ClassroomCourse::groupBy('subject')->orderBy('subject')->pluck('subject','subject')->toArray(),null,['class' => 'form-control','placeholder' => '-- Select Subject --','required']) }}
                    <div id="new-subject-container" style="display: none">
                        {{ Form::label('new_subject') }}
                        {{ Form::text('new_subject',null,['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="col col-sm-4">
                    {{ Form::label('name','Course Name') }}
                    {{ Form::text('name',null,['class' => 'form-control','required']) }}
                </div>
                <div class="col col-sm-4">
                    {{ Form::label('upload','PDF Instruction Upload') }}
                    {{ Form::file('upload',['accept' => '.pdf']) }}
                    <br>
                    @if ($classroom->s3_path)<small><a target="_blank" href="{{ $classroom->s3_url }}">{{ $classroom->s3_path }}</a></small>@endif
                </div>
            </div>
        </div>
        <div class="card-header">Assign To:</div>
        <div class="card-body">
            <table class="table table-bordered" id="assignment-list">
                @if ($classroom)
                    @foreach ($classroom->assignments()->with('user:id,name')->get() AS $assignment)
                        <tr id="assignment-{{ $assignment->id }}">
                            <td>
                                {{ Form::hidden('deleteList[]',null,['class' => 'delete-list']) }}
                                {{ $assignment->user->name }}
                            </td>
                            <td class="text-center">
                                <a class="btn btn-outline-secondary" href="{{ route('admin.classroom.view-results',[$assignment->user_id,$assignment->classroom_course_id]) }}">View
                                    Results</a></td>
                            <td class="text-center"><a class="text-danger remove-assignment" href="#" data-id="{{ $assignment->id }}"><i class="fa fa-trash"></i></a></td>
                        </tr>
                    @endforeach
                @endif
            </table>

            <div class="text-center">
                {{ Form::submit('Save',['class' => 'btn btn-secondary']) }}
            </div>
        </div>
    </div>

    {{ Form::close() }}

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    {{ Form::select('user_id',$users,null,['class' => 'form-control','id' => 'user-list','placeholder' => '-- Select Employee --']) }}
                </div>
                <div class="col">
                    <a href="#" id="add-user" class="btn btn-outline-secondary">Add <i class="fa fa-plus"></i></a>
                </div>
            </div>
        </div>
    </div>

    <table id="hidden-table" class="d-none">
        <tr>
            <td>
                {{ Form::hidden('userList[]') }}
                <span class="name"></span>
            </td>
            <td></td>
            <td class="text-center">
                <a href="#" class="text-danger" onclick="$(this).parent().parent().remove(); return false;"><i class="fa fa-trash"></i></a>
            </td>
        </tr>
    </table>

@stop

@push('scripts')
    <!-- show "new subject" -->
    <script type="text/javascript">
        $('#subject').change(function () {
            const $val = $(this).val();

            if ($val === '0') {
                $('#new-subject-container').show();
                $('input[name=new_subject]').attr('required', true);
            } else {
                $('#new-subject-container').hide();
                $('input[name=new_subject]').attr('required', false).val('');
            }
        });

        $('#add-user').click(function ($e) {
            $e.preventDefault();
            const $userList = $('#user-list');
            const $val = $userList.val();
            const $name = $userList.find(':selected').text();
            if ($val) {
                let $tr = $('#hidden-table tr').clone();
                $tr.find('input').val($val);
                $tr.find('.name').html($name);
                $tr.appendTo('#assignment-list');
            }
        });

        $('.remove-assignment').click(function ($e) {
            $e.preventDefault();
            const $id = $(this).data('id');
            const $tr = $('#assignment-' + $id);
            $tr.find('.delete-list').val($id);
            $tr.fadeOut();
        });
    </script>
@endpush
