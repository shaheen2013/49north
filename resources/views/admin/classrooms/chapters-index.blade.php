@extends('layouts.main',['activeMenu' => 'classroom'])
@section('title', $course->name . ' Chapters')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.classroom.index',['c' => $course->company]) }}">Courses</a></li>
@endsection

@section('content1')

    <h4>{{ $course->name }}</h4>
    <a href="{{ route('admin.classroom.chapter.create',$course->id) }}" class="btn btn-outline-secondary"><i class="fa fa-plus"></i></a>
    {{ Form::open(['url' => route('admin.classroom.chapter.update-chapter-order')]) }}
    <table class="table table-bordered">
        <thead>
        <tr>

        </tr>
        </thead>
        <tbody>
        @php
            $delSection = 'chapter';
        @endphp
        @foreach ($course->chapters AS $chapter)
            <tr class="del-{{ $delSection }}-{{ $chapter->id }}">
                <td class="text-center">{{ Form::number('orderval[' . $chapter->id . ']',$chapter->orderval,['class' => 'form-control','min' => 1]) }}</td>
                <td><a href="{{ route('admin.classroom.chapter.edit',$chapter->id) }}">{{ $chapter->chapter_name }}</a></td>
                <td class="text-center">
                    <a title="Course User" class="deletejson text-danger btn" data-token="{{ csrf_token() }}" data-url="{{ route('admin.classroom.chapter.destroy',$chapter->id) }}" data-id="{{ $chapter->id }}" data-section="{{ $delSection }}"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ Form::submit('Update Order',['class' => 'btn btn-secondary']) }}
    {{ Form::close() }}

@stop
