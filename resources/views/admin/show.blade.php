@extends('admin.app')
@section('content')

    @if(session()->get('addteacher') == 1)

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
                Teacher
                <a href="#" data-toggle="modal" data-target="#modalForAddCourse"><button class="btn btn-success float-right">Add Teacher</button></a>
              </div>
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
                              <th>DOB</th>
                              <th>Gender</th>
                              <th>Action</th>                          
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                            $i = 1;
                            @endphp
                            @foreach($teacher as $teacherData) 
                                <tr>
                                    <td>{{ $i++}}</td>
                                    <td>{{$teacherData->name}}</td>
                                    <td>{{$teacherData->email}}</td>
                                    <td>{{$teacherData->phone}}</td>
                                    <td>{{$teacherData->dob}}</td>
                                    <td>{{$teacherData->gender}}</td>
                                    <td>
                                      <button class="btn btn-success subupdate" data-toggle="modal" data-target="#updateCourse{{$teacherData->id}}" value="{{$teacherData->id}}"><i class="fa-solid fa-pen-to-square"></i></button>
                                      <a href="{{route('admin.trash',['id'=>$teacherData->id, 'v'=>'trash teacher'])}}"><button class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button></a>
                                    </td>
                                  
                                    
    
                                    <!-- update  subject-->
                                    <!-- Modal For Update teacher -->
                                    <div class="modal fade myModal" id="updateCourse{{$teacherData->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog " role="document">
                                        <form class="refreshFrm" id="addCourseFrm" action="{{route('admin.update-teacher')}}" method="POST" >
                                            @csrf
                                        <div class="modal-content myModal-content" >
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Update</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="">Name</label>
                                                    <input type="text" name="name" class="form-control" value="{{$teacherData->name}}">
                                                    @error('name')
                                                        <div class="aler alert-danger">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Email</label>
                                                    <input type="email" name="email" class="form-control" value="{{$teacherData->email}}" readonly>
                                                    @error('email')
                                                        <div class="aler alert-danger">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Phone</label>
                                                    <input type="text" name="phone" class="form-control" value="{{$teacherData->phone}}" >
                                                    @error('phone')
                                                        <div class="aler alert-danger">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="">DOB</label>
                                                    <input type="date" name="dob" class="form-control" value="{{$teacherData->dob}}" >
                                                    @error('dob')
                                                        <div class="aler alert-danger">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Gender</label>
                                                    <select class="form-control" name="gender">
                                                        @if($teacherData->gender == "male")
                                                         <option value="{{$teacherData->gender}}">Male</option>
                                                         <option value="female">Female</option>
                                                         <option value="other">Other</option>
                                                         @elseif($teacherData->gender == "female")
                                                         <option value="{{$teacherData->gender}}">Female</option>
                                                         <option value="male">Male</option>
                                                         <option value="other">Other</option>
                                                         @else
                                                         <option value="{{$teacherData->gender}}">Other</option>
                                                         <option value="male">Male</option>
                                                         <option value="female">Female</option>
                                                        @endif
                                                    </select>
                                                    @error('gender')
                                                        <div class="aler alert-danger">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Password</label>
                                                    <input type="text" name="password" class="form-control" placeholder="If you want to change">
                                                    @error('password')
                                                        <div class="aler alert-danger">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            
                                            <input type="hidden" name="teacher_id" value="{{$teacherData->id}}">
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
    
    
      
    <!-- Modal For Add teacher -->
    <div class="modal fade" id="modalForAddCourse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
     <form action="{{route('admin.add-teacher')}}" method="POST">
       <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Teacher</h5>
          
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
          @csrf
        <div class="modal-body">
          <div class="col-md-12">
              <div class="form-group">
                  <label for="">Name</label>
                  <input type="text" name="name" value="{{old('name')}}" placeholder="Name" class="form-control">
                  @error('name')
                    <div class="aler alert-danger">{{$message}}</div>
                  @enderror
              </div>
              <div class="form-group">
                  <label for="">Email</label>
                  <input type="email" name="email" value="{{old('email')}}" placeholder="Email" class="form-control">
                  @error('email')
                    <div class="aler alert-danger">{{$message}}</div>
                  @enderror
              </div>
              <div class="form-group">
                  <label for="">Phone</label>
                  <input type="phone" name="phone" value="{{old('phone')}}" placeholder="Phone" class="form-control">
                  @error('phone')
                    <div class="aler alert-danger">{{$message}}</div>
                  @enderror
              </div>
              <div class="form-group">
                  <label for="">DOB</label>
                  <input type="date" name="dob" value="{{old('dob')}}" placeholder="dob" class="form-control">
                  @error('dob')
                    <div class="aler alert-danger">{{$message}}</div>
                  @enderror
              </div>
              <div class="form-group">
                  <label for="">Password</label>
                  <input type="password" name="password" value="{{old('password')}}" placeholder="Password" class="form-control">
                  @error('password')
                    <div class="aler alert-danger">{{$message}}</div>
                  @enderror
              </div>
              <div class="form-group">
                  <label for="">Gender</label>
                  <select name="gender" id="" class="form-control">
                      <option>Gender:-</option>
                      <option value="male">Male</option>
                      <option value="female">Female</option>
                      <option value="other">Other</option>
                  </select>
                  @error('gender')
                      <div class="alert alert-danger">{{$message}}</div>
                  @enderror
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add Now</button>
        </div>
        
      </div>
     </form>
    </div>
    </div>
    <!-- end add teacher modal -->

    @elseif(session()->get('trashteacher') == 1)

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
                Trash Teacher
              </div>
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
                              <th>DOB</th>
                              <th>Gender</th>
                              <th>Action</th>                          
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                            $i = 1;
                            @endphp
                            @foreach($teacher as $teacherData) 
                                <tr>
                                    <td>{{ $i++}}</td>
                                    <td>{{$teacherData->name}}</td>
                                    <td>{{$teacherData->email}}</td>
                                    <td>{{$teacherData->phone}}</td>
                                    <td>{{$teacherData->dob}}</td>
                                    <td>{{$teacherData->gender}}</td>
                                    <td>
                                        <a href="{{route('admin.trash',['id'=>$teacherData->id, 'v'=>'restore teacher'])}}"><button class="btn btn-success"><i class="fa-solid fa-trash-can-arrow-up"></i></button></a>
                                        <a href="{{route('admin.trash',['id'=>$teacherData->id, 'v'=>'delete teacher'])}}"><button class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
              </div>
            </div>
          </div>
     </div>

    @elseif(session()->get('allowteacher') == 1)

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
                Permission Teacher
              </div>
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
                              <th>DOB</th>
                              <th>Gender</th>
                              <th>Status</th>
                              <th>Action</th>                          
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                            $i = 1;
                            @endphp
                            @foreach($teacher as $teacherData) 
                                <tr>
                                    <td>{{ $i++}}</td>
                                    <td>{{$teacherData->name}}</td>
                                    <td>{{$teacherData->email}}</td>
                                    <td>{{$teacherData->phone}}</td>
                                    <td>{{$teacherData->dob}}</td>
                                    <td>{{$teacherData->gender}}</td>
                                    @if($teacherData->permission == 'No')
                                        <td><i class="fa-solid fa-xmark text-danger"></i></td>
                                        <td>
                                        <a href="{{route('admin.allow',['id'=>$teacherData->id, 'v'=>'allow teacher'])}}"><button class="btn btn-success subupdate" ><i class="fa-solid fa-check"></i></button></a>
                                        </td>
                                    @else
                                        <td><i class="fa-solid fa-check text-success"></i></td>
                                        <td>
                                        <a href="{{route('admin.allow',['id'=>$teacherData->id, 'v'=>'block teacher'])}}"><button class="btn btn-danger subupdate" ><i class="fa-solid fa-xmark"></i></button></a>
                                        </td>
                                    @endif
                                  
                                </tr>
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