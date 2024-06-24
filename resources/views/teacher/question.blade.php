@extends('teacher.app')
@section('content')
<div class="conatiner-fluid">
    <div class="card ">
        <div class="card-header bg-primary">
            <div id="exancountdown" class="float-right"></div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-10 offset-md-1 ">
                    @foreach($examTime as $timeData)
                            <input type="hidden" id="examTimeCount" value="{{$timeData->exam_time}}">
                            <input type="hidden" class="form-control" id="examDateCount" value="{{$timeData->exam_date}}">
                        @section('timer-script')
                            @include('teacher.timer')
                        @endsection   
                    @endforeach    
                    
                    @if(session('status') && session('status') !='')
                    <div class="alert alert-success">{{session('status')}}</div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 offset-md-1 mt-2">
                    <div class="card">
                        <div class="card-header bg-primary">
                            Update Exam
                        </div>
                        <div class="card-body">
                        @foreach($examTime as $timeData)
                            <form action="{{route('teacher.update-exam',['id'=>$timeData->id, 'v'=>'update exam'])}}" method="post">
                                @csrf
                                    <div class="form-group">
                                        <label>Class</label>
                                        <select class="form-control" name="class">
                                        @foreach($stdclass as $stdclss)
                                                @if($timeData->class == $stdclss->id)
                                                <option value="{{$stdclss->id}}" id="select_class">{{$stdclss->class_name}}</option>
                                                @endif
                                        @endforeach  
                                        @foreach($clas as $cls)
                                            @foreach($stdclass as $stdclss)
                                                @if(($cls->class_id == $stdclss->id) && ($timeData->class != $stdclss->id))
                                                <option value="{{$stdclss->id}}">{{$stdclss->class_name}}</option>
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
                                            @foreach($stdclass as $classData)
                                                @if($classData->id == $timeData->class)
                                                @foreach($sub as $dataSub)
                                                    @if($timeData->subject == $dataSub->id)
                                                    <option value="{{$dataSub->id}}" >Class:- {{$classData->class_name}}, {{$dataSub->sub_name}}</option>
                                                    @endif  
                                                @endforeach  
                                                @endif
                                            @endforeach
                                        @foreach($sub as $dataSub)
                                        @if($timeData->subject != $dataSub->id)
                                            @foreach($stdclass as $classData)
                                                @if($classData->id == $dataSub->class_id)
                                                    <option value="{{$dataSub->id}}">Class:- {{$classData->class_name}}, {{$dataSub->sub_name}}</option>
                                                @endif
                                            @endforeach
                                        @endif  
                                        @endforeach
                                        </select>
                                        @error('subject')
                                        <div class="alert alert-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Date</label>
                                        <input type="date" class="form-control" name="date" value="{{$timeData->exam_date}}">
                                        @error('date')
                                        <div class="alert alert-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Time</label>
                                        <input type="time" class="form-control" name="time" value="{{$timeData->exam_time}}">
                                        @error('time')
                                        <div class="alert alert-danger">{{$message}}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Exam Time Limit</label><br>
                                        <label for="">Hrs</label>
                                        <input type="number" class="form-control" placeholder="Hrs" name="hrs" value="{{$timeData->exam_hr}}">
                                        @error('hrs')
                                        <div class="alert alert-danger">{{$message}}</div>
                                        @enderror
                                        <label for="">Min</label>
                                        <input type="number" class="form-control" placeholder="Min" name="min" value="{{$timeData->exam_min}}">
                                        @error('min')
                                        <div class="alert alert-danger">{{$message}}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Exam Title</label>
                                        <input type="" name="title" class="form-control" placeholder="Input Exam Title" value="{{$timeData->exam_title}}">
                                        @error('title')
                                        <div class="alert alert-danger">{{$message}}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Exam Description</label>
                                        <input type="text" name="description" class="form-control" rows="4" placeholder="Input Exam Description" value="{{$timeData->exam_description}}">
                                        @error('description')
                                        <div class="alert alert-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <input type="hidden" name="examTimeId"  value="{{$timeData->id}}">
                                @endforeach 
                                    <button class="btn btn-success" id="updateExamBtn" style="">Update</button>

                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-7  mt-2">
                    <div class="card">
                        <div class="card-header bg-primary">
                        <div >
                                @php
                                $queCount = 0;
                                @endphp
                                @foreach($examQue as $dataQues)
                                    @php
                                    $queCount ++;
                                    @endphp
                                @endforeach
                                Exam Question's <span class="badge badge-pill badge-warning ml-2">{{$queCount}}</span>
                            
                            <a href="#" data-toggle="modal" data-target="#modalForAddQuestion"><button class="btn btn-success float-right" id="addExamQueBtn">Add</button></a>
                        </div>
                        </div>
                        <div class="card-body">
                            <div  style="overflow-x:auto; height:738px;">
                                    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                    @if($queCount > 0)
                                        <thead>
                                            <tr>
                                                    <!-- <th class="text-left pl-1">Course Name</th> -->
                                                    <!-- <th class="text-center" width="20%">Action</th> -->
                                                    <th>
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                Course Name
                                                            </div>
                                                            <div class="col-md-2 offset-md-1">
                                                                Action
                                                            </div>    
                                                        </div>
                                                    </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php 
                                                $i = 1;
                                            @endphp
                                            @foreach($examQue as $dataQues)
                                                <tr>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <b>{{$i++}}.) <sup class="text-danger">num:{{$dataQues->ques_num}}</sup> {{$dataQues->question}}</b>
                                                                <p>
                                                                    @if($dataQues->answer == "opt1")
                                                                            <span class="pl-4 text-success">A:- {{$dataQues->opt1}}</span><br>
                                                                    @else
                                                                            <span class="pl-4 ">A:- {{$dataQues->opt1}}</span><br>
                                                                    @endif
                                                                    @if($dataQues->answer == "opt2")
                                                                            <span class="pl-4 text-success">B:- {{$dataQues->opt2}}</span><br>
                                                                    @else
                                                                            <span class="pl-4 ">B:- {{$dataQues->opt2}}</span><br>
                                                                    @endif
                                                                    @if($dataQues->answer == "opt3")
                                                                            <span class="pl-4 text-success">C:- {{$dataQues->opt3}}</span><br>
                                                                    @else
                                                                            <span class="pl-4 ">C:- {{$dataQues->opt3}}</span><br>
                                                                    @endif
                                                                    @if($dataQues->answer == "opt4")
                                                                            <span class="pl-4 text-success">D:- {{$dataQues->opt4}}</span><br>
                                                                    @else
                                                                            <span class="pl-4 ">D:- {{$dataQues->opt4}}</span><br>
                                                                    @endif
                                                                </p>
                                                            </div>
                                                            <div class="col-md-2 offset-md-1">
                                                                <a href="#" data-toggle="modal" data-target="#modalForUpdateQue{{$dataQues->id}}"><button class="btn btn-success mt-1" ><i class="fa-solid fa-pen-to-square"></i></button>
                                                                <a href="{{route('teacher.delete-ques',['id'=> $dataQues->id, 'v' => 'question delete'])}}"><button class="btn btn-danger mt-1"><i class="fa-solid fa-trash-can"></i></button></a>
                                                            </div>
                                                        </div>
                                                    
                                                    </td>    

                                                    <!-- add question -->
                                                        <!-- Modal For Update Question -->
                                                        <div class="modal fade" id="modalForUpdateQue{{$dataQues->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Update Question<br></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                
                                                                
                                                                <form class="refreshFrm" action="{{ route('teacher.update-ques')}}" method="post" id="addQuestionFrm">
                                                                @csrf
                                                                    <div class="modal-body">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                        <label>Question</label>
                                                                        <input type="text" name="question" id="course_name" class="form-control" placeholder="Input question" autocomplete="off" value="{{$dataQues->question}}">
                                                                        @error('question')
                                                                        <div class="alert alert-danger">{{$message}}</div>
                                                                        @enderror
                                                                        </div>

                                                                        <fieldset>
                                                                        <legend>MCQ Options</legend>
                                                                        <div class="form-group">
                                                                            <label>Choice A</label>
                                                                            <input type="text" name="choice_A" id="choice_A" class="form-control" placeholder="Input choice A" autocomplete="off" value="{{$dataQues->opt1}}">
                                                                            @error('choice_A')
                                                                            <div class="alert alert-danger">{{$message}}</div>
                                                                            @enderror
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label>Choice B</label>
                                                                            <input type="text" name="choice_B" id="choice_B" class="form-control" placeholder="Input choice B" autocomplete="off"  value="{{$dataQues->opt2}}">
                                                                            @error('choice_B')
                                                                            <div class="alert alert-danger">{{$message}}</div>
                                                                            @enderror
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label>Choice C</label>
                                                                            <input type="text" name="choice_C" id="choice_C" class="form-control" placeholder="Input choice C" autocomplete="off"  value="{{$dataQues->opt3}}">
                                                                            @error('choice_C')
                                                                            <div class="alert alert-danger">{{$message}}</div>
                                                                            @enderror
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label>Choice D</label>
                                                                            <input type="text" name="choice_D" id="choice_D" class="form-control" placeholder="Input choice D" autocomplete="off"  value="{{$dataQues->opt4}}">
                                                                            @error('choice_D')
                                                                            <div class="alert alert-danger">{{$message}}</div>
                                                                            @enderror
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label>Correct Answer</label>
                                                                            @if($dataQues->answer == "opt1")
                                                                                <input type="text" name="correctAnswer" id="" class="form-control" placeholder="A or B or C or D" autocomplete="off"  value="A">
                                                                            @elseif($dataQues->answer == "opt2")
                                                                                <input type="text" name="correctAnswer" id="" class="form-control" placeholder="A or B or C or D" autocomplete="off"  value="B">
                                                                            @elseif($dataQues->answer == "opt3")
                                                                                <input type="text" name="correctAnswer" id="" class="form-control" placeholder="A or B or C or D" autocomplete="off"  value="C">
                                                                            @elseif($dataQues->answer == "opt4")
                                                                                <input type="text" name="correctAnswer" id="" class="form-control" placeholder="A or B or C or D" autocomplete="off"  value="D">
                                                                            @endif
                                                                            @error('correctAnswer')
                                                                            <div class="alert alert-danger">{{$message}}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Mark</label>
                                                                            <input type="text" name="mark" id="" class="form-control"  autocomplete="off"  value="{{$dataQues->ques_num}}">
                                                                            @error('mark')
                                                                            <div class="alert alert-danger">{{$message}}</div>
                                                                            @enderror
                                                                        </div>
                                                                        </fieldset>
                                                                    </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    
                                                                    <input type="hidden" name="queId" value="{{$dataQues->id}}">
                                                                
                                                                    <button type="submit" class="btn btn-primary">Update Now</button>
                                                                    </div>
                                                                </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end update question modal -->                                   
                                                </tr>
                                                
                                            @endforeach
                                        </tbody>  
                                        @else
                                        <div>
                                                No Question available
                                        </div>
                                        @endif    
                                    </table>
                            </div>        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>








<!-- add question -->
<!-- Modal For Add Question -->
<div class="modal fade" id="modalForAddQuestion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
     <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Question for <br></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     
     
      <form class="refreshFrm" action="{{route('teacher.add-ques')}}" method="post" id="addQuestionFrm">
      @csrf
        <div class="modal-body">
          <div class="col-md-12">
            <div class="form-group">
              <label>Question</label>
              <input type="text" name="question" id="course_name" class="form-control" placeholder="Input question" autocomplete="off" value="{{old('question')}}">
              @error('question')
              <div class="alert alert-danger">{{$message}}</div>
              @enderror
            </div>

            <fieldset>
              <legend>MCQ Options</legend>
              <div class="form-group">
                  <label>Choice A</label>
                  <input type="text" name="choice_A" id="choice_A" class="form-control" placeholder="Input choice A" autocomplete="off" value="{{old('choice_A')}}">
                  @error('choice_A')
                  <div class="alert alert-danger">{{$message}}</div>
                  @enderror
              </div>

              <div class="form-group">
                  <label>Choice B</label>
                  <input type="text" name="choice_B" id="choice_B" class="form-control" placeholder="Input choice B" autocomplete="off"  value="{{old('choice_B')}}">
                  @error('choice_B')
                  <div class="alert alert-danger">{{$message}}</div>
                  @enderror
              </div>

              <div class="form-group">
                  <label>Choice C</label>
                  <input type="text" name="choice_C" id="choice_C" class="form-control" placeholder="Input choice C" autocomplete="off"  value="{{old('choice_C')}}">
                  @error('choice_C')
                  <div class="alert alert-danger">{{$message}}</div>
                  @enderror
              </div>

              <div class="form-group">
                  <label>Choice D</label>
                  <input type="text" name="choice_D" id="choice_D" class="form-control" placeholder="Input choice D" autocomplete="off"  value="{{old('choice_D')}}">
                  @error('choice_D')
                  <div class="alert alert-danger">{{$message}}</div>
                  @enderror
              </div>

              <div class="form-group">
                  <label>Correct Answer</label>
                  <input type="text" name="correctAnswer" id="" class="form-control" placeholder="A or B or C or D" autocomplete="off"  value="{{old('correctAnswer')}}">
                  @error('correctAnswer')
                  <div class="alert alert-danger">{{$message}}</div>
                  @enderror
              </div>
              <div class="form-group">
                    <label>Mark</label>
                    <input type="text" name="mark" id="" class="form-control" placeholder="Mark of this question" autocomplete="off">
                    @error('mark')
                        <div class="alert alert-danger">{{$message}}</div>
                    @enderror
              </div>
            </fieldset>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          @foreach($examTime as $timeData)
          <input type="hidden" name="examId" value="{{$timeData->id}}">
          @endforeach
          <button type="submit" class="btn btn-primary">Add Now</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- end add question modal -->
@endsection