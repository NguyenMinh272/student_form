@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Update Mark</h3>
                    </div>
                    <div class="col-md-6">
                        <a href="{{route('students.index')}}" class="btn btn-primary float-end">Student List</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if(isset($student))
                    {!! Form::open(array('route' => 'students.subjects.marks.storeMark','method' => 'post')) !!}
                @else
                    {!! Form::open(array('route' => ['students.subjects.createSubjects',$student->id],'method' => 'put')) !!}
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('name', 'Student name', []) !!}
                            {!! Form::hidden('student_id', $student->id ) !!}
                            {!! Form::text('student_name', $student->full_name, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group ">
                            <table class="table" id="table_field" >
                                <thead class="col-md-12">
                                <tr>
                                    <th>Subject</th>
                                    <th>Mark</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody class="row_container table_field">
                                <td>
                                    {!! Form::select('subject_id[]', $student->subjects->pluck('name', 'id'), null, ['class' => 'form-control ']) !!}
                                </td>
                                <td>
                                    {!! Form::text('mark', '', ['class' => 'form-control']) !!}
                                </td>
                                <td>
                                    {{--                                    <button class="btn btn-warning" onclick="handleClick()">Add</button>--}}
                                    <input type="button" name="add" id="add" value="Add" class="btn btn-warning">
                                </td>
                                </tbody>
                            </table>
                        </div>
                        @if(!isset($student))
                            {!! Form::submit('Create', ['class' => 'btn btn-success mt-2','style'=>'margin-left:12px'])!!}
                        @else
                            {!! Form::submit('Update',['class'=> 'btn btn-success mt-2','style'=>'margin-left:12px']) !!}
                        @endif
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script type="text/javascript">
                {{--// document.getElementById("add").onclick = function() {handleClick()};--}}
                {{--var html = '';--}}
                {{--html += '<tbody class="row_container">';--}}
                {{--html += '<td> {!! Form::select('subject_id[]', $student->subjects->pluck('name', 'id'), null, ['class' => 'form-control']) !!}</td>';--}}
                {{--html += '<td> {!! Form::text('mark','', ['class' => 'form-control']) !!}</td>';--}}
                {{--html += '<td> <input type="button" name="remove" id="remove"  value="Remove" class="btn btn-danger" ></td></tbody>';--}}
                {{--function handleClick() {--}}
                {{--    document.getElementById("table_field").append(html);--}}
                {{--}--}}

                $(document).ready(function () {
                    $("#add").on('click', function () {
                        var html = '';
                        html += '<tbody class="row_container">';
                        html += '<td> {!! Form::select('subject_id[]', $student->subjects->pluck('name', 'id'), null, ['class' => 'form-control']) !!}</td>';
                        html += '<td> {!! Form::text('mark','', ['class' => 'form-control']) !!}</td>';
                        html += '<td> <input type="button" name="remove" id="remove"  value="Remove" class="btn btn-danger" ></td></tbody>';
                        var x = 1;
                        $("#table_field").append(html);
                    });
                });
                $(document).on('click', '#remove', function () {
                    $(this).closest('tbody').remove();
                });
            </script>


    {{--    <script>--}}
    {{--        document.querySelector('.form-group select').addEventListener('change', function (e) {--}}
    {{--            window.location.href = '{{ URL::current() }}?subject_id=' + e.target.value--}}
    {{--        })--}}
    {{--    </script>--}}
@endsection
