@extends('admin.app')
@section('content')

<div class="container-fluid mb-2">
    <div class="row">
        <div class="col-md-12">
            @if(session('status') && session('status')!='')
            <div class="alert alert-success">{{session('status')}}</div>
            @endif
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-primary">
            <div>
                Class
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table id="example" class="table table-striped table-bordered dt-responsive nowrap editTable"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>S.NO.</th>
                                <th>Class</th>
                                <th>Teacher</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i = 1;
                            @endphp
                            @foreach($class as $classData)
                            <tr>
                                <td>{{ $i++}}</td>
                                <td>{{$classData->class_name}}</td>
                                <td>
                                @foreach($clasTeacher as $clsteach)
                                    @if($classData->id == $clsteach->class_id)
                                        @foreach($teacher as $teacherData1)
                                            @if($clsteach->teacher_id == $teacherData1->id)
                                               <p>{{$teacherData1->email}},</p>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                                </td>
                                <td>
                                    <button class="btn btn-success subupdate" data-toggle="modal"
                                        data-target="#updateClassAssign{{$classData->id}}" value="{{$classData->id}}"><i
                                            class="fa-solid fa-pen-to-square"></i></button>
                                </td>



                                <!-- update  subject-->
                                <!-- Modal For Update teacher -->
                                <div class="modal fade myModal" id="updateClassAssign{{$classData->id}}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog " role="document">
                                        <form class="refreshFrm" id="addCourseFrm"
                                            action="{{route('admin.assign-class')}}" method="POST">
                                            @csrf
                                            <div class="modal-content myModal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Assign</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="">Class</label>
                                                        <input type="text" name="class" class="form-control"
                                                            value="{{$classData->class_name}}" readonly>
                                                        @error('class')
                                                        <div class="aler alert-danger">{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Assign Teacher</label>
                                                        <select name="teacher" id="" class="form-control">
                                                            @foreach($teacher as $teacherData)
                                                                <option value="{{$teacherData->id}}">{{$teacherData->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>

                                                    <input type="hidden" name="class_id" value="{{$classData->id}}">
                                                    <button type="submit" class="btn btn-primary">Update Now</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- end update teacher modal -->

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection