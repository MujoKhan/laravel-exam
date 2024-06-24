@extends('teacher.app')
@section('content')
  @if(session()->get('sub') == 1)
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
              Subject Of Your Manage Here
              <a href="#" data-toggle="modal" data-target="#modalForAddCourse"><button class="btn btn-success float-right">Add Subject</button></a>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                  <table id="example" class="table table-striped table-bordered dt-responsive nowrap editTable" style="width:100%">
                      <thead>
                          <tr>
                            <th>S.NO.</th>
                            <th>Class</th>
                            <th>Subject</th>
                            <th>Action</th>                          
                          </tr>
                      </thead>
                      <tbody>
                          @php 
                          $i = 1;
                          @endphp
                          @foreach($sub as $subdata) 
                              <tr>
                                  <td>{{ $i++}}</td>
                                  @foreach($stdclass as $stdcls)
                                      @if($subdata->class_id == $stdcls->id)
                                          <td>{{$stdcls->class_name}}</td>
                                      @endif
                                  @endforeach
                                  <td>{{$subdata->sub_name}}</td>
                                  <td>
                                    <button class="btn btn-success subupdate" data-toggle="modal" data-target="#updateCourse{{$subdata->id}}" value="{{$subdata->id}}"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <a href="{{route('teacher.trash',['id'=>$subdata->id, 'v'=>'trash subject'])}}"><button class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button></a>
                                  </td>
                                
                                  

                                  <!-- update  subject-->
                                  <!-- Modal For Update Course -->
                                  <div class="modal fade myModal" id="updateCourse{{$subdata->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog " role="document">
                                      <form class="refreshFrm" id="addCourseFrm" action="{{route('teacher.update-sub')}}" method="POST" >
                                          @csrf
                                      <div class="modal-content myModal-content" >
                                          <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Update</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                          </div>
                                          <div class="modal-body">
                                          <div class="col-md-12">
                                              <div class="form-group">
                                              <label for="">Class</label>
                                              <select class="form-control" name="class_name">
                                                @foreach($stdclass as $stdclss1)
                                                  @if($subdata->class_id == $stdclss1->id)
                                                      <option value="{{$stdclss1->id}}">{{$stdclss1->class_name}}</option>
                                                  @endif
                                                @endforeach

                                              @foreach($clas as $cls)
                                                  @foreach($stdclass as $stdclss)
                                                      @if(($cls->class_id == $stdclss->id) && ($subdata->class_id != $stdclss->id))
                                                      <option value="{{$stdclss->id}}">{{$stdclss->class_name}}</option>
                                                      @endif
                                                  @endforeach    
                                              @endforeach
                                              </select>
                                              <div class="form-group">
                                              <label>Subject</label>
                                              <input type="" name="subject_name" id="course_name" class="form-control" value="{{$subdata->sub_name}}" placeholder="{{$subdata->id}}">
                                              </div>
                                          </div>
                                          </div>
                                          <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                          
                                          <input type="hidden" name="sub_id" value="{{$subdata->id}}">
                                          <button type="submit" class="btn btn-primary">Update Now</button>
                                          </div>
                                      </div>
                                      </form>
                                      </div>
                                  </div>
                                  <!-- end update subject modal -->

                              </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
            </div>
          </div>
        </div>
   </div>


    <!-- add subject -->
<!-- Modal For Add Course -->
<div class="modal fade" id="modalForAddCourse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
   <form action="{{route('teacher.add-sub')}}" method="POST">
     <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Subject</h5>
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
        @csrf
      <div class="modal-body">
        <div class="col-md-12">
          <div class="form-group">
            <label>Class</label>
            <select class="form-control" name="class_name">
              @foreach($clas as $cls)
                  @foreach($stdclass as $stdclss)
                    @if($cls->class_id == $stdclss->id)
                      <option value="{{$stdclss->id}}">{{$stdclss->class_name}}</option>
                    @endif
                  @endforeach    
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Subject</label>
            <input type="" name="subject_name" id="subject_name" class="form-control" placeholder="Subject Name" required="" autocomplete="off">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="hidden" name="teacher_id" value="{{Auth::guard('teacher')->user()->id}}">
        <button type="submit" class="btn btn-primary">Add Now</button>
      </div>
      
    </div>
   </form>
  </div>
</div>
<!-- end add subject modal -->


  @elseif(session()->get('trash') == 1)
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
            Your Trash Subjects
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
              
                  <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                      <thead>
                          <tr>
                            <th>S.NO.</th>
                            <th>Class</th>
                            <th>Subject</th>
                            <th>Restore</th>
                            <th>Delete</th>
                          
                          </tr>
                      </thead>
                      <tbody>
                          @php 
                          $i = 1;
                          @endphp
                          @foreach($sub as $subdata) 
                              <tr>
                                  <td>{{ $i++}}</td>
                                  @foreach($stdclass as $stdcls)
                                      @if($subdata->class_id == $stdcls->id)
                                          <td>{{$stdcls->class_name}}</td>
                                      @endif
                                  @endforeach
                                  <td>{{$subdata->sub_name}}</td>
                                  <td><a href="{{route('teacher.trash',['id'=>$subdata->id, 'v'=>'trash restore'])}}"><button class="btn btn-success"><i class="fa-solid fa-trash-arrow-up"></i></button></a></td>
                                  <td><a href="{{route('teacher.trash',['id'=>$subdata->id, 'v'=>'trash delete'])}}"><button class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button></a></td>
                                  
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
   

