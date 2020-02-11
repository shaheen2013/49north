@extends('layouts.main')
@section('title', $course->name)

@section('content1')

    @if ($course->s3_path)
        <iframe name="pdf_iframe" src="{{ $course->s3_url }}" class="invoice-pdf-frame"></iframe>
    @endif

    <table class="table table-bordered" style="margin-top: 30px;">
        <thead>
        <tr>
            <th>Chapter</th>
            <th>Status</th>
            <th>Chapter Outline</th>
        </tr>
        </thead>
        @php $curStatus = ''; $curChapterID = 0; @endphp
        @foreach ($course->chapters()->withCount('questions')->get() AS $chapter)
            {{-- check that there are questions --}}
            @php
                $lastStatus = $curStatus; $curStatus = $course->getStatus($chapter->id);
                $lastChapterID = $curChapterID; $curChapterID = $chapter->id;
            @endphp
            @if ($chapter->questions_count)
                <tr>
                    @if ($curStatus == 'complete')
                        <td>
                            {{ $chapter->chapter_name }}
                        </td>
                        <td class="text-center">
                            <a class="btn btn-danger confirm-repeat" href="{{ route('employee.classroom.repeat-chapter',$chapter->id) }}">Start Over</a>
                            <a class="btn btn-outline-secondary" href="{{ route('employee.classroom.take-course',$chapter->id) }}">Check Answers</a>
                        </td>
                    @elseif (($curStatus == 'unavailable' || $curStatus == 'start-over') && (!$lastStatus || $lastStatus == 'complete' || isset($alreadyCompletedChapters[$lastChapterID])))
                        <td><a href="{{ route('employee.classroom.take-course',$chapter->id) }}">{{ $chapter->chapter_name }}</a></td>
                        <td class="text-center">
                            <a class="btn btn-secondary" href="{{ route('employee.classroom.take-course',$chapter->id) }}">Start Chapter</a>
                        </td>
                    @elseif ($curStatus == 'in-progress')
                        @php $nextQuestion = $chapter->nextQuestion(); @endphp
                        <td>
                            <a href="{{ route('employee.classroom.take-course',[$chapter->id,'qid' => $nextQuestion->id]) }}">{{ $chapter->chapter_name }}</a>
                        </td>
                        <td class="text-center">
                            <a class="btn btn-secondary" href="{{ route('employee.classroom.take-course',[$chapter->id,'qid' => $nextQuestion->id]) }}">Continue</a>
                        </td>
                    @else
                        <td>{{ $chapter->chapter_name }}</td>
                        <td class="text-center">
                            @lang('courses.chapter_status.' . $curStatus)
                        </td>
                    @endif
                    <td class="text-center">
                        @if ($chapter->s3_path)
                            <a href="{{ $chapter->s3_url }}" target="_blank" class="btn btn-outline-secondary">Outline</a>
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
            @endif
        @endforeach
    </table>


@stop


@push('scripts')
    <!-- repeat chapter -->
    <script type="text/javascript">
        $('.confirm-repeat').click(function () {
            return confirm('Are you sure you want to start over?  All your previous answers will be reset ... ');
        })
    </script>
@endpush
