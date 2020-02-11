@extends('layouts.main',['activeMenu' => 'classroom'])
@section('title', $companyName . ' Courses')

@section('content1')

    <a href="{{ route('admin.classroom.create',['c' => $company]) }}" class="btn btn-outline-secondary"><i class="fa fa-plus"></i></a>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Course</th>
            <th>Chapters (edit)</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        @php
            $delSection = 'classroom';
            $curSubject = '';
        @endphp
        @foreach ($courses AS $course)
            @php
                $prevSubject = $curSubject;
                $curSubject = $course->subject;
            @endphp
            @if ($prevSubject != $curSubject)
                <tr>
                    <th colspan="4">
                        {{ $curSubject }}
                    </th>
                </tr>
            @endif
            <tr class="del-{{ $delSection }}-{{ $course->id }}">
                <td><a href="{{ route('admin.classroom.edit',$course->id) }}">{{ $course->name }}</a></td>
                <td class="text-center"><a href="{{ route('admin.classroom.chapter.list',$course->id) }}">{{ $course->chapters_count }}</a></td>
                <td class="text-center">{{ $course->created_at->format('M d, Y') }}</td>
                <td class="text-center">
                    <a title="Course User" class="deletejson text-danger btn" data-token="{{ csrf_token() }}" data-url="{{ route('admin.classroom.destroy',$course->id) }}" data-id="{{ $course->id }}" data-section="{{ $delSection }}"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@stop
