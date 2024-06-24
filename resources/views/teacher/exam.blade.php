@extends('teacher.app')
@section('content')
  @if(session()->get('add-exam') == 1)
  <div class="container-fluid mb-2">
       <div class="row">
           <div class="col-md-12">
               @if(session('status') && session('status')!='')
               <div class="alert alert-success">{{session('status')}}</div>
               @endif
           </div>
       </div>
   </div>
 
  
  <div class="container-fluid">
      <div class="card">
        <div class="card-header bg-primary">
          <div>
             Your Exam Manage Here
            <a href="#" data-toggle="modal" data-target="#modalForExam"><button class="btn btn-success float-right">Add Exam</button></a>
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
                            <th>Date</th>
                            <th>Time</th>
                            <th>Time Limite</th>
                            <th>Status</th>
                            <th>Complete</th>
                            <th>T.Ques</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Update</th>
                            <th>Trash</th>
                            <th>De/Active</th>
                            <th>Time Up/Down</th>
                          </tr>
                      </thead>
                      <tbody>
                          @php 
                          $i = 1;
                          $queCount = 0;
                          @endphp
                        @foreach($examtime as $examData)
                          @php 
                            $queCount = 0;
                          @endphp
                            @foreach($que as $queData)
                                @if($examData->id == $queData->exam_id)
                                    @php 
                                      $queCount ++;
                                    @endphp
                                @endif
                              @endforeach
                              <tr>
                                  <td>{{$i++}}</td>
                                  <td>{{$examData->class}}</td>
                                  @foreach($sub as $dataSub)
                                    @if($dataSub->id == $examData->subject)
                                      <td>{{$dataSub->sub_name}}</td>
                                    @endif  
                                  @endforeach
                                  <td>{{$examData->exam_date}}</td>
                                  <td>{{$examData->exam_time}}</td>
                                  <td>{{$examData->exam_hr}}h : {{$examData->exam_min}}m</td>
                                  @if($examData->exam_status == "Deactive")
                                    <td>Deactive</td>
                                  @else
                                     <td>Active</td>  
                                  @endif   
                                  @if($examData->exam_done == "No")
                                    <td>{{$examData->exam_done}}</td>
                                  @else
                                     <td>{{$examData->exam_done}}</td>  
                                  @endif   
                                
                                  <td>{{$queCount}}</td>
                                  <td>{{$examData->exam_title}}</td>
                                  <td>{{$examData->exam_description}}</td>
                                  <td><a href="{{route('teacher.manage-exam',['id'=>$examData->id])}}" ><button class="btn btn-success" ><i class="fa-solid fa-gears"></i></button></a></td>
                                  <td><a href="{{route('teacher.trash-exam',['id'=>$examData->id])}}"><button class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button></a></td>
                                  <td>
                                    @if($examData->exam_status == "Deactive")
                                      <a href="{{route('teacher.exam-schedule',['id' => $examData->id, 'v' => 'active'])}}"><button class="btn btn-warning"><i class="fas fa-check"></i></button></a>
                                    @else
                                    <a href="{{route('teacher.exam-schedule',['id' => $examData->id, 'v' => 'deactive'])}}"><button class="btn btn-warning"><i class="fa-solid fa-ban"></i></button></a>
                                    @endif
                                  </td>
                                  @if($examData->exam_done == "No")
                                    <td><a href="{{ route('teacher.exam-done',['id' => $examData->id, 'v' => 'Yes'])}}"><button class="btn btn-success">Done</button></a></td>
                                  @else
                                  <td><a href="{{ route('teacher.exam-done',['id' => $examData->id, 'v' => 'No'])}}"><button class="btn btn-success">Not Done</button></a></td>
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

    <!-- add exam -->
<!-- Modal For Add Exam -->
<div class="modal fade" id="modalForExam" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
   <form class="refreshFrm" id="addExamFrm" action="{{route('teacher.exam-add')}}" method="post">
     @csrf
     <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Exam</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
        <div class="form-group">
            <label>Class</label>
            <select class="form-control" name="class">
              <option >Select Class:-</option>
              @foreach($clas as $cls)
                  @foreach($stdclass as $stdclss)
                    @if($cls->class_id == $stdclss->id)
                      <option value="{{$stdclss->id}}" id="select_class">{{$stdclss->class_name}}</option>
                    @endif
                  @endforeach    
              @endforeach
            </select>
            @error('class')
            <div class="alert alert-danger">{{$message}}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="">Subject</label>
              <select class="form-control" name="subject">
              <option >Select Subject:-</option>
                @foreach($sub as $dataSub)
                  @foreach($stdclass as $classData)
                    @if($classData->id == $dataSub->class_id)
                      <option value="{{$dataSub->id}}">Class:- {{$classData->class_name}}, {{$dataSub->sub_name}}</option>
                    @endif
                  @endforeach
                @endforeach
              </select>
              @error('subject')
            <div class="alert alert-danger">{{$message}}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="">Date</label>
              <input type="date" class="form-control" name="date" value="{{old('date')}}">
              @error('date')
            <div class="alert alert-danger">{{$message}}</div>
            @enderror
          </div>
          <div class="form-group">
            <label for="">Time</label>
              <input type="time" class="form-control" name="time" value="{{old('time')}}">
              @error('time')
            <div class="alert alert-danger">{{$message}}</div>
            @enderror
          </div>

          <div class="form-group">
            <label>Exam Time Limit</label><br>
            <label for="">Hrs</label>
            <input type="number" class="form-control" placeholder="Hrs" name="hrs" value="{{old('hrs')}}">
            @error('hrs')
            <div class="alert alert-danger">{{$message}}</div>
            @enderror
            <label for="">Min</label>
            <input type="number" class="form-control" placeholder="Min" name="min" value="{{old('min')}}">
            @error('min')
            <div class="alert alert-danger">{{$message}}</div>
            @enderror
          </div>

          <div class="form-group">
            <label>Exam Title</label>
            <input type="" name="title" class="form-control" placeholder="Input Exam Title" value="{{old('title')}}">
            @error('title')
            <div class="alert alert-danger">{{$message}}</div>
            @enderror
          </div>

          <div class="form-group">
            <label>Exam Description</label>
            <textarea name="description" class="form-control" rows="4" placeholder="Input Exam Description" value="{{old('description')}}"></textarea>
            @error('description')
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
<!-- add exam modal end -->

  @elseif(session()->get('trash-exam') == 1)
  <div class="container-fluid mb-2">
       <div class="row">
           <div class="col-md-12">
               @if(session('status') && session('status')!='')
               <div class="alert alert-success">{{session('status')}}</div>
               @endif
           </div>
       </div>
   </div>
  <div class="container-fluid">
      <div class="card">
        <div class="card-header bg-primary">
          Your Trash Exam
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
                            <th>Title</th>
                            <th>Time</th>
                            <th>Time Limite</th>
                            <th>T.Ques</th>
                            <th>Que Display</th>
                            <th>Description</th>
                            <th>Restore/Delete</th>
                            
                            
                          </tr>
                      </thead>
                      <tbody>
                          @php 
                          $i = 1;
                          $queCount = 0;
                          @endphp
                        @foreach($examtimeTrash as $examData)
                          @php 
                            $queCount = 0;
                          @endphp
                            @foreach($que as $queData)
                                @if($examData->id == $queData->exam_id)
                                    @php 
                                      $queCount ++;
                                    @endphp
                                @endif
                              @endforeach
                              <tr>
                                  <td>{{$i++}}</td>
                                  <td>{{$examData->class}}</td>
                                  @foreach($sub as $dataSub)
                                    @if($dataSub->id == $examData->subject)
                                      <td>{{$dataSub->sub_name}}</td>
                                    @endif  
                                  @endforeach
                                  <td>{{$examData->exam_title}}</td>
                                  <td>{{$examData->exam_time}}</td>
                                  <td>{{$examData->exam_hr}}h : {{$examData->exam_min}}m</td>
                                  <td>{{$queCount}}</td>
                                  <td>{{$examData->exam_que_display}}</td>
                                  <td>{{$examData->exam_description}}</td>
                                  <td>
                                    <a href="{{route('teacher.exam-backup',['id'=>$examData->id, 'v' => 'exam restore'])}}" ><button class="btn btn-success" ><i class="fa-solid fa-trash-arrow-up"></i></button></a>
                                    <a href="{{route('teacher.exam-backup',['id'=>$examData->id, 'v' => 'exam delete'])}}"><button class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button></a>
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
  @endif

  
@endsection  
