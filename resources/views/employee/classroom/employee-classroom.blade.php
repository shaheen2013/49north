@extends('employee.layout')
@section('title', 'Classroom')

@section('content')

    <table class="table table-bordered" style="margin-top: 30px">
        <thead>
        <tr>
            <th>Course</th>
            <th>Outline</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($courses AS $course)
            <tr>
                <td>
                    <a href="{{ route('employee.classroom.chapters',$course->id) }}">{{ $course->name }}</a><br>
                </td>
                <td class="text-center">
                    @if ($course->s3_path)
                        <a href="{{ $course->s3_url }}" target="_blank" class="btn btn-outline-secondary">Outline</a>
                    @else
                        N/A
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@stop
