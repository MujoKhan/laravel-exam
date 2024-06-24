@extends('teacher.app')
@section('content')
@if(session()->get('add-examinee') == 1)
<div class="container mb-3 col-md-12">
    @if(session('status') && session('status')!='')
    <div class="alert alert-success">{{session('status')}}</div>
    @endif
    <div class="card ">
        <div class="card-header bg-primary">
            <div>
                All Classes
                <a href="#" data-toggle="modal" data-target="#modalForAddExaminee"><button
                        class="btn btn-success float-right">Add Student</button></a>
            </div>
        </div>
        <div class="card-body">
            @foreach($classTeacher as $clsTeacherData)
                @foreach($clas as $classData)
                    @if($clsTeacherData->class_id == $classData->id)
                    <a href="{{route('teacher.class-data',['id'=>$classData->id])}}"><button
                            class="btn btn-success mt-1 mb-2">Class {{$classData->class_name}}</button></a>
                    @endif
                @endforeach
            @endforeach
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-primary">
            Your Class Students Here Allow/Block
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table id="example" class="table table-striped table-bordered dt-responsive nowrap editTable" style="width:100%">
                        <thead>
                            <tr>
                            <th>S.NO.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Gender</th>
                            <th>Class</th>
                            <th>Status</th>
                            <th>Permission</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                            $i = 1;
                            @endphp
                            @foreach($classTeacher as $clsTeacherData)
                                @foreach($student as $studentData)
                                    @if($clsTeacherData->class_id == $studentData->class) 
                                            <tr>
                                                <td>{{ $i++}}</td>
                                                <td>{{$studentData->name}}</td>
                                                <td>{{$studentData->email}}</td>
                                                <td>{{$studentData->phone}}</td>
                                                <td>{{$studentData->gender}}</td>
                                                @foreach($clas as $classData)
                                                    @if($clsTeacherData->class_id == $classData->id)
                                                        <td>{{$classData->class_name}}</td>
                                                    @endif
                                                @endforeach    
                                                @if($studentData->permission == "No")
                                                    <td><i class="fa-solid fa-ban text-danger"></i></td>
                                                    <td><a href="{{ route('teacher.examinee-permission',['id' =>$studentData->id, 'v'=>'examinee allow'])}}"><button class="btn btn-success"><i class="fas fa-check"></i></button></a></td>
                                                @else
                                                    <td><i class="fas fa-check text-success"></i></td>
                                                    <td><a href="{{ route('teacher.examinee-permission',['id' =>$studentData->id, 'v'=>'examinee block'])}}"><button class="btn btn-danger"><i class="fa-solid fa-ban"></i></button></a></td>
                                                @endif    
                                                
                                            </tr>
                                    @endif        
                                @endforeach   
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- add question -->
<!-- Modal For Add Examinee -->
<div class="modal fade" id="modalForAddExaminee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Examinee/Student<br></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('teacher.add-examinee')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">Class</label>
                        <select name="class" id="" class="form-control">
                            @foreach($classTeacher as $clsTeacherData)
                            @foreach($clas as $clasData)
                            @if($clsTeacherData->class_id == $clasData->id)
                            <option value="{{ $clasData->id}}">{{ $clasData->class_name}}</option>
                            @endif
                            @endforeach
                            @endforeach
                        </select>
                        @error('class')
                            <div class="alert alert-ddanger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" name="name" placeholder="Enter Name" value="{{old('name')}}"
                            class="form-control">
                        @error('name')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" name="email" placeholder="Enter Email" value="{{old('email')}}"
                            class="form-control">
                        @error('email')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Phone</label>
                        <input type="text" name="phone" placeholder="Enter Phone" value="{{old('phone')}}"
                            class="form-control">
                        @error('phone')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">DOB</label>
                        <input type="date" name="dob" placeholder="" value="{{old('dob')}}" class="form-control">
                        @error('dob')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" name="password" placeholder="Enter Password" value="{{old('password')}}"
                            class="form-control">
                        @error('password')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <label for="">Gender</label>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="gender" value="male">Male
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="gender" value="female">Female
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="gender" value="other">Other
                        </label>
                    </div>
                    <button type="submit" class="btn btn-success mt-2">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end Add Examinee modal -->

@elseif(session()->get('trash-examinee') == 1)
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            @if(session('status') && session('status')!='')
                <div class="alert alert-success">{{session('status')}}</div>
            @endif
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-primary">
            Your Trash Examinee
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table id="example" class="table table-striped table-bordered dt-responsive nowrap editTable" style="width:100%">
                        <thead>
                            <tr>
                            <th>S.NO.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Gender</th>
                            <th>Class</th>
                            <th>Restore/Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                            $i = 1;
                            @endphp
                            @foreach($classTeacher as $clsTeacherData)
                                @foreach($student as $studentData)
                                    @if($clsTeacherData->class_id == $studentData->class) 
                                            <tr>
                                                <td>{{ $i++}}</td>
                                                <td>{{$studentData->name}}</td>
                                                <td>{{$studentData->email}}</td>
                                                <td>{{$studentData->phone}}</td>
                                                <td>{{$studentData->gender}}</td>
                                                @foreach($clas as $classData)
                                                    @if($clsTeacherData->class_id == $classData->id)
                                                        <td>{{$classData->class_name}}</td>
                                                    @endif
                                                @endforeach    
                                                <td>
                                                    <a href="{{ route('teacher.examinee-backup',['id'=>$studentData->id, 'v' => 'examinee restore'])}}"><button class="btn btn-success"><i class="fa-solid fa-trash-arrow-up"></i></button></a>   
                                                    <a href="{{ route('teacher.examinee-backup',['id'=>$studentData->id, 'v' => 'examinee delete'])}}"><button class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button></a>
                                                </td>    
                                            </tr>
                                    @endif        
                                @endforeach   
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection