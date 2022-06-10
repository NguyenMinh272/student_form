@extends('layouts/master')
@section('content')
    <div class="container">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h3>Student Management</h3>
                </div>
                <div class="col-md-6">
                    <a href="{{route('students.create')}}" class="btn btn-success float-end">New Student</a>
                    <a href="" class="btn btn-success float-end">Send Mail</a>
                </div>
                {!! Form::open(array('route' => 'students.index','method' => 'get'))!!}
                <div class="row input-daterange">
                    <div class="col-md-2">
                        {!! Form::text('age_from',  '', ['class' => 'form-control','placeholder' =>'From age']) !!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::text('age_to',  '', ['class' => 'form-control', 'placeholder'=>'To age']) !!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::text('mark_from',  '', ['class' => 'form-control','placeholder' =>'From mark']) !!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::text('mark_to',  '', ['class' => 'form-control', 'placeholder'=>'To mark']) !!}
                    </div>
                    <div class="col-md-2">
                        <select name="option" class="form-control">
                            <option value="">--Option--</option>
                            <option value="1">Learned all</option>
                            <option value="2">Don't learn</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        {!! Form::submit('Search', ['class' => 'btn btn-success '])!!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Student</th>
                    <th scope="col">Avatar</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Birthday</th>
                    <th colspan="2">Action</th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($students))
                    @foreach ($students as $key => $student)
                        <tr id="tr{{$student->id}}">
                            <th scope="row">{{$key+=1}}</th>
                            <td class="td-full-name">{{$student->full_name}}</td>
                            <td><img src="{{asset('images/'.$student->image)}}" style="width:40px; height: 50px"></td>
                            <td class="td-email">{{$student->email}}</td>
                            <td class="td-phone">{{$student->phone}}</td>
                            <td>{{$student->birthday}}</td>
                            <td>
                                {!! Form::open(['route' => ['students.destroy', $student->id], 'method' => 'DELETE']) !!}
                                <a class="btn btn-info" href="{{ route('students.show', $student->id) }}"><i
                                        class="bi bi-eye-fill"></i></a>
                                {{--                                <a class="btn btn-warning" href="{{ route('students.edit', $student->id) }}"><i class="bi bi-pencil-square"></i></a>--}}
                                {!! Form::button('<i class="bi bi-pencil-square"></i>',['class'=>'btn btn-warning edit-btn','data-toggle'=>'modal','data-target'=>'#exampleModal-' . $student->id]) !!}
                                <a class="btn btn-success"
                                   href="{{route('students.subjects.createSubjects', $student->id)}}"><i
                                        class="bi bi-plus-circle-fill"></i></a>
                                {!! Form::button('<i class="bi bi-trash3-fill"></i>', ['type' => 'submit', 'class' => 'btn btn-danger']) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal-{{$student->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{route('student_update_api', $student->id )}}" id="editStudentModal" name="editStudentModal" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            @csrf
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    {!! Form::label('name', 'Student name', []) !!}
                                                    {!! Form::text('full_name', isset($student) ? $student->full_name : '', ['class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    {!! Form::label('faculty', 'Faculty', []) !!}
                                                    {!! Form::select('faculty_id', $faculties ,isset($student) ? $student->faculty: '', ['class' => 'form-control']) !!}

                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    {!! Form::label('email', 'Email', []) !!}
                                                    {!! Form::text('email', isset($student) ? $student->email : '', ['class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    {!! Form::label('address', 'Address', []) !!}
                                                    {!! Form::text('address', isset($student) ? $student->address : '', ['class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    {!! Form::label('birthday', 'Birthday', []) !!}
                                                    {!! Form::date('birthday', isset($student) ? $student->birthday : '', ['class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    {!! Form::label('phone', 'Phone number', []) !!}
                                                    {!! Form::text('phone', isset($student) ? $student->phone : '', ['class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('gender', 'Gender', []) !!}
                                                {!! Form::radio('gender', '0',  $student->gender == 0 ? true : false) !!}
                                                <span>Nam</span>
                                                {!! Form::radio('gender', '1',  $student->gender == 1 ? true : false) !!}
                                                <span>Nữ</span>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    {!! Form::label('image', 'Image', []) !!}
                                                    {!! Form::file('image',  ['class' => 'form-control-file']) !!}
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary btn-update" data-modal="exampleModal-{{$student->id}}">Save changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                </tbody>

            </table>
            {{$students->links("pagination::bootstrap-4")}}
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">

        $('.btn-update').click(function () {

            modal_id = $(this).closest('button').attr("data-modal"); //exampleModal-2

            input_full_name = $('#'+modal_id + ' input[name="full_name"]')[0];
            input_faculty = $('#'+modal_id + ' select[name="faculty_id"]')[0];
            input_email = $('#'+modal_id + ' input[name="email"]')[0];
            input_address = $('#'+modal_id + ' input[name="address"]')[0];
            input_phone = $('#'+modal_id + ' input[name="phone"]')[0];
            input_birthday = $('#'+modal_id + ' input[name="birthday"]')[0];
            input_gender = $('#'+modal_id + ' input[name="gender"]:checked')[0];
            input_image = $('#'+modal_id + ' input[name="image"]')[0];
            input_token = $('#'+modal_id + ' input[name="_token"]')[0];
            url_action = $('#'+modal_id + ' form');

            console.log(
                // input_full_name.value,
                // input_email.value,
                // input_address.value,
                // input_gender.value,
                // input_phone.value,
                // input_birthday.value,
                // input_image.file[0],
                // url_action.attr('action'),
                // input_token
                // input_faculty.value,
            )

            formData = new FormData()

            formData.append('full_name', input_full_name.value)
            formData.append('faculty_id', input_faculty.value)
            formData.append('email', input_email.value)
            formData.append('address', input_address.value)
            formData.append('phone', input_phone.value)
            formData.append('birthday', input_birthday.value)
            formData.append('image', input_image.files[0])
            formData.append('gender', input_gender.value)
            formData.append('_token', input_token.value)

            $.ajax({
                type: "POST",
                url: url_action.attr('action'),
                dataType: 'json',
                timeout: 30000,
                contentType: false,
                processData: false,
                data: formData,
                enctype: 'multipart/form-data',
                success: function({ data, message }) {
                    $("#tr" + data.id + ' .td-full-name').html(data.full_name);
                    $("#tr" + data.id + ' .td-phone').html(data.phone);
                    $("#tr" + data.id + ' .td-email').html(data.email);
                    // $("#tr" + data.id + ' .td-birthday').html(data.birthday);
                    $("#tr" + data.id + ' img')[0].src = "{{ asset('images') }}" + '/' +  data.image;
                    // $('#'+modal_id).hide();
                    $('#'+modal_id).modal('hide');
                },
                error: function(err) {
                    console.log(err);
                },
                done: function(msg){
                    if (parseFloat(msg)){
                        return false;
                    } else {
                        return true;
                    }
                }
            });
        })

    </script>
@endsection
