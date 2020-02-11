@extends('layouts.main',['activeMenu' => 'classroom'])
@section('title', $user->full_name . ' Answers for ' . $course->name)

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.classroom.index',['c' => $course->company]) }}">Courses</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.classroom.chapter.list',$course->id) }}">{{ $course->name }}</a></li>
@endsection

@section('content1')

    <h4>{{ $course->name }}</h4>

    <table class="table table-bordered">
        @php $curStatus = ''; $curChapterID = 0; @endphp
        @foreach ($chapters AS $chapter)
            @php
                $lastStatus = $curStatus; $curStatus = $course->getStatus($chapter->id,$user->id);
                $lastChapterID = $curChapterID; $curChapterID = $chapter->id;
            @endphp

            <tr>
                <th colspan="2">{{ $chapter->chapter_name }}</th>
                <th class="text-center">
                    @if ($curStatus != 'unavailable' && $curStatus != 'start-over')
                        <a href="{{ route('admin.classroom.chapter.view-chapter-results',[$user->id,$chapter->id]) }}" class="btn btn-outline-secondary">@lang('courses.chapter_status.' . $curStatus)</a>
                    @endif
                </th>
            </tr>

        @endforeach

    </table>
@stop

