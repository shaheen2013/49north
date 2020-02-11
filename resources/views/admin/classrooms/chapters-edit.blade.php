@extends('layouts.main',['activeMenu' => 'classroom'])
@section('title', $chapter->name . ' Chapter')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.classroom.index',['c' => $course->company]) }}">Courses</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.classroom.chapter.list',$course->id) }}">{{ $course->name }}</a></li>
@endsection

@section('content1')

    <h4>{{ $course->name }}</h4>

    {!! Form::model($chapter,['url' => route('admin.classroom.chapter.store'),'files' => true]) !!}
    {!! Form::hidden('id') !!}
    {!! Form::hidden('classroom_course_id') !!}

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col col-sm-4">
                    <div class="form-group">
                        {!! Form::label('chapter_name') !!}
                        {!! Form::text('chapter_name',null,['class' => 'form-control','required']) !!}
                    </div>
                </div>
                {{--                <div class="col col-sm-4">
                                    <div class="form-group">
                                        {!! Form::label('instructions') !!}
                                        {!! Form::textarea('instructions',null,['class' => 'form-control']) !!}
                                    </div>
                                </div>--}}
                <div class="col col-sm-4">
                    {!! Form::label('upload','PDF Instruction Upload') !!}
                    {!! Form::file('upload',['accept' => '.pdf']) !!}
                    <br>
                    @if ($chapter->s3_path)
                        <small><a target="_blank" href="{{ $chapter->s3_url }}">{{ $chapter->s3_path }}</a></small>
                    @endif
                </div>
                <div class="col col-sm-4">
                    <div class="text-center">
                        {!! Form::submit('Save',['class' => 'btn btn-secondary']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    @if ($chapter->id)
        <div class="card" style="margin-top: 30px;">
            <div class="card-header">Questions</div>

            <div class="card-body">
                {!! Form::open(['url' => route('admin.classroom.chapter.add-question',$chapter->id)]) !!}
                <div class="row">
                    <div class="col">
                        {!! Form::select('question_type',\App\Models\ClassroomQuestion::$questionTypes,null,['class' => 'form-control']) !!}
                    </div>
                    <div class="col">
                        {!! Form::submit('Add',['class' => 'btn btn-outline-secondary']) !!}
                    </div>
                </div>
                {!! Form::close() !!}

                {!! Form::open(['url' => route('admin.classroom.chapter.update-question-order')]) !!}
                <table class="table table-bordered">
                    @php $delSection = 'question'; @endphp
                    @foreach ($chapter->classroomSections()->with('classroomQuestionsOrder')->get() AS $section)
                        <tr>
                            <th colspan="4">{{ $section->orderval }}) {{ $section->section_name }}</th>
                        </tr>
                        @foreach ($section->classroomQuestionsOrder AS $question)
                            <tr class="del-{{ $delSection }}-{{ $question->id }}">
                                <td class="text-center">{!! Form::number('orderval[' . $question->id . ']',$question->orderval,['class' => 'form-control text-center','min' => 1, 'style' => 'min-width: 80px']) !!}</td>
                                <td><a href="{{ route('admin.classroom.chapter.edit-question',$question->id) }}">{{ $question->question }}</a></td>
                                <td class="text-center">{{ $question->question_type }}</td>
                                <td class="text-center">
                                    <a title="Delete User" class="deletejson text-danger btn" data-token="{{ csrf_token() }}" data-url="{{ route('admin.classroom.chapter.destroy-question',$question->id) }}" data-id="{{ $question->id }}" data-section="{{ $delSection }}"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </table>

                {!! Form::submit('Update Order',['class' => 'btn btn-secondary']) !!}
                {!! Form::close() !!}

                @endif
            </div>
        </div>

@stop

