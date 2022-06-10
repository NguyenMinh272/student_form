@extends('layouts.master')
@section('content')
    {!! Form::open(['method'=>'GET', 'route' => ['students.subjects.marks.createMark', $student->id]]) !!}
    {!! Form::submit('Add Mark',['class'=>'btn btn-primary']) !!}
    {!! Form::close() !!}
    @if(!empty($student))
        <table class="table table-bordered">
            <tr>
                <td rowspan="10">{{$student->full_name}}</td>
                <td colspan="2">Information</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{$student->email}}</td>
            </tr>
            <tr>
                <td>Phone</td>
                <td>{{$student->phone}}</td>
            </tr>
            <tr>
                <td>Address</td>
                <td>{{$student->address}}</td>
            </tr>
            <tr>
                <td rowspan="7">Subjects</td>
            </tr>
            @foreach($student->subjects as $subject)
                <tr>
                    <td>{{$subject->name}}: <span>{{$subject->pivot->mark}}</span></td>
                </tr>
            @endforeach
        </table>
    @endif
@endsection
