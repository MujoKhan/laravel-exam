@extends('teacher.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if(session('status') && session('status')!='')
               <div class="alert alert-success">{{session('status')}}</div>
            @endif                
        </div>
    </div>
</div>
<div class="container mb-3">
    <div class="card">
        <div class="card-header bg-primary">
            <div class=" mb-3 text-center d-flex justify-content-between">
                <h5> Class <sup><b>{{session()->get('class_name')}}</b></sup></h5>
                <a href="{{route('teacher.examinee',['v'=>'add examinee'])}}"><button class="btn btn-success">Back</button></a>
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
                                    <th>Gender</th>
                                    <th>DOB</th>    
                                    <th>Action</th>
                          
                                </tr>
                            </thead>
                            <tbody>
                                @php 
                                $i = 1;
                                @endphp
                                @foreach($std as $stdData)             
                                    <tr>
                                        <td>{{ $i++}}</td>
                                        <td>{{$stdData->name}}</td>
                                        <td>{{$stdData->email}}</td>
                                        <td>{{$stdData->phone}}</td>
                                        <td>{{$stdData->gender}}</td>
                                        <td>{{$stdData->dob}}</td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#modalForUpdateExaminee{{$stdData->id}}"><button class="btn btn-success"><i class="fa-solid fa-pen-to-square"></i></button></a>
                                            <a href="{{ route('teacher.examinee-trash',['id'=>$stdData->id])}}"><button class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button></a>
                                        </td>

                                        <!-- add question -->
                                        <!-- Modal For Update Examinee -->
                                        <div class="modal fade" id="modalForUpdateExaminee{{$stdData->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Update Examinee/Student<br></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('teacher.examinee-update')}}" method="post">
                                                            @csrf
                                                            <div class="form-group">
                                                                <label for="">Class</label>
                                                                <select name="class" id="" class="form-control">
                                                                    @foreach($clas as $clasData)
                                                                        @if($stdData->class == $clasData->id)
                                                                            <option value="{{ $clasData->id}}">{{ $clasData->class_name}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                    
                                                                    @foreach($classTeacher as $clsTeacherData)
                                                                        @foreach($clas as $clasData)
                                                                            @if(($clsTeacherData->class_id == $clasData->id) && ($stdData->class != $clasData->id))
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
                                                                <input type="text" name="name" placeholder="Enter Name" value="{{$stdData->name}}"
                                                                    class="form-control">
                                                                @error('name')
                                                                <div class="alert alert-danger">{{$message}}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Email</label>
                                                                <input type="email" name="email" placeholder="Enter Email" value="{{$stdData->email}}"
                                                                    class="form-control" readonly>
                                                                @error('email')
                                                                <div class="alert alert-danger">{{$message}}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Phone</label>
                                                                <input type="text" name="phone" placeholder="Enter Phone" value="{{$stdData->phone}}"
                                                                    class="form-control">
                                                                @error('phone')
                                                                <div class="alert alert-danger">{{$message}}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">DOB</label>
                                                                <input type="date" name="dob" placeholder="" value="{{$stdData->dob}}" class="form-control">
                                                                @error('dob')
                                                                <div class="alert alert-danger">{{$message}}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Password</label>
                                                                <input type="password" name="password" placeholder="If you want to change" value=""
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
                                                            <input type="hidden" name="examineeId" value="{{$stdData->id}}">
                                                            <button type="submit" class="btn btn-success mt-2">Submit</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end Update Examinee modal -->


                                    </tr>
                                @endforeach
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    


    <div class="card mt-5">
        <div class="card-header bg-primary">
            Exam Rank
        </div>
        <div class="card-body">
        <div class="row">
                <div class="col-md-12">
                    <table id="example2" class="table table-striped table-bordered dt-responsive nowrap editTable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S.NO.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Title</th>
                                    <th>T.Ques</th>
                                    <th>Answers</th> 
                                    <th>T.Marks</th>
                                    <th>Marks</th>
                                    <th>Precentage</th>  
                                    <th>Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php 
                                $i = 1;
                                $answerCount = 0;
                                $answerNum = 0;
                                @endphp
                                @foreach($stdAnswrUserCount as $ansData)
                                    @php
                                        $answerCount = 0;
                                        $answerNum = 0;
                                    @endphp
                                    @foreach($stdAnswer as $ansData1)
                                        @if( ($ansData->std_id == $ansData1->std_id) && ( $ansData->exam_id == $ansData1->exam_id))
                                            @foreach($examQues as $queData)
                                                @if( ($ansData1->question_id == $queData->id) && ($ansData1->std_answer == $queData->answer) && ($queData->exam_id == $ansData1->exam_id))
                                                    @php
                                                        $answerCount++;
                                                        $answerNum += $queData->ques_num ;
                                                    @endphp                                                         
                                                @endif
                                            @endforeach                  
                                        @endif
                                    @endforeach   
                                    @foreach($std as $stdData)
                                        @if($ansData->std_id == $stdData->id)
                                            @foreach($examTime as $examData)
                                                @if($ansData->exam_id == $examData->id)
                                                    @foreach($subject as $subData)
                                                        @if($examData->subject == $subData->id)
                                                            @foreach($queNumCount as $queCountData)
                                                                @if($ansData->exam_id == $queCountData->exam_id)
                                                                    @foreach($queNumCount as $numData)
                                                                        @if($numData->exam_id == $ansData->exam_id)
                                                                            @if((($answerNum*100/$numData->total_num) >= 97 ) && (($answerNum*100/$numData->total_num) <= 100 ))
                                                                                <tr class="text-success">
                                                                                    <td>{{$i++}}</td>
                                                                                    <td>{{$stdData->name}}</td>
                                                                                    <td>{{$stdData->email}}</td>
                                                                                    <td>{{$subData->sub_name}}</td>
                                                                                    <td>{{$examData->exam_title}}</td>
                                                                                    <td>{{$numData->total_question}}</td>
                                                                                    <td>{{$answerCount}}</td>
                                                                                    <td>{{$numData->total_num}}</td>
                                                                                    <td>{{$answerNum}}</td>
                                                                                    <td>{{number_format($answerNum*100/$numData->total_num, 2, '.', ',')}} % </td> 
                                                                                    <td>O</td>
                                                                                </tr> 
                                                                            @elseif((($answerNum*100/$numData->total_num) >= 87) && (($answerNum*100/$numData->total_num) <= 96.9))
                                                                                <tr class="text-success">
                                                                                        <td>{{$i++}}</td>
                                                                                        <td>{{$stdData->name}}</td>
                                                                                        <td>{{$stdData->email}}</td>
                                                                                        <td>{{$subData->sub_name}}</td>
                                                                                        <td>{{$examData->exam_title}}</td>
                                                                                        <td>{{$numData->total_question}}</td>
                                                                                        <td>{{$answerCount}}</td>
                                                                                        <td>{{$numData->total_num}}</td>
                                                                                        <td>{{$answerNum}}</td>
                                                                                        <td>{{number_format($answerNum*100/$numData->total_num, 2, '.', ',')}} % </td> 
                                                                                        <td>A+</td>
                                                                                </tr> 
                                                                            @elseif((($answerNum*100/$numData->total_num) >= 77) && (($answerNum*100/$numData->total_num) <= 86.9))
                                                                                <tr class="text-success">
                                                                                        <td>{{$i++}}</td>
                                                                                        <td>{{$stdData->name}}</td>
                                                                                        <td>{{$stdData->email}}</td>
                                                                                        <td>{{$subData->sub_name}}</td>
                                                                                        <td>{{$examData->exam_title}}</td>
                                                                                        <td>{{$numData->total_question}}</td>
                                                                                        <td>{{$answerCount}}</td>
                                                                                        <td>{{$numData->total_num}}</td>
                                                                                        <td>{{$answerNum}}</td>
                                                                                        <td>{{number_format($answerNum*100/$numData->total_num, 2, '.', ',')}} % </td> 
                                                                                        <td>A</td>
                                                                                </tr> 
                                                                            @elseif((($answerNum*100/$numData->total_num) >= 67) && (($answerNum*100/$numData->total_num) <= 76.9))
                                                                                <tr class="text-warning">
                                                                                        <td>{{$i++}}</td>
                                                                                        <td>{{$stdData->name}}</td>
                                                                                        <td>{{$stdData->email}}</td>
                                                                                        <td>{{$subData->sub_name}}</td>
                                                                                        <td>{{$examData->exam_title}}</td>
                                                                                        <td>{{$numData->total_question}}</td>
                                                                                        <td>{{$answerCount}}</td>
                                                                                        <td>{{$numData->total_num}}</td>
                                                                                        <td>{{$answerNum}}</td>
                                                                                        <td>{{number_format($answerNum*100/$numData->total_num, 2, '.', ',')}} % </td> 
                                                                                        <td>B+</td>
                                                                                </tr> 
                                                                            @elseif((($answerNum*100/$numData->total_num) >= 57) && (($answerNum*100/$numData->total_num) <= 66.9))
                                                                                <tr class="text-warning">
                                                                                        <td>{{$i++}}</td>
                                                                                        <td>{{$stdData->name}}</td>
                                                                                        <td>{{$stdData->email}}</td>
                                                                                        <td>{{$subData->sub_name}}</td>
                                                                                        <td>{{$examData->exam_title}}</td>
                                                                                        <td>{{$numData->total_question}}</td>
                                                                                        <td>{{$answerCount}}</td>
                                                                                        <td>{{$numData->total_num}}</td>
                                                                                        <td>{{$answerNum}}</td>
                                                                                        <td>{{number_format($answerNum*100/$numData->total_num, 2, '.', ',')}} % </td> 
                                                                                        <td>B</td>
                                                                                </tr> 
                                                                            @elseif((($answerNum*100/$numData->total_num) >= 47) && (($answerNum*100/$numData->total_num) <= 56.9))
                                                                                <tr class="text-warning">
                                                                                        <td>{{$i++}}</td>
                                                                                        <td>{{$stdData->name}}</td>
                                                                                        <td>{{$stdData->email}}</td>
                                                                                        <td>{{$subData->sub_name}}</td>
                                                                                        <td>{{$examData->exam_title}}</td>
                                                                                        <td>{{$numData->total_question}}</td>
                                                                                        <td>{{$answerCount}}</td>
                                                                                        <td>{{$numData->total_num}}</td>
                                                                                        <td>{{$answerNum}}</td>
                                                                                        <td>{{number_format($answerNum*100/$numData->total_num, 2, '.', ',')}} % </td> 
                                                                                        <td>C</td>
                                                                                </tr> 
                                                                            @elseif((($answerNum*100/$numData->total_num) >= 37) && (($answerNum*100/$numData->total_num) <= 46.9))
                                                                                <tr class="text-primary">
                                                                                        <td>{{$i++}}</td>
                                                                                        <td>{{$stdData->name}}</td>
                                                                                        <td>{{$stdData->email}}</td>
                                                                                        <td>{{$subData->sub_name}}</td>
                                                                                        <td>{{$examData->exam_title}}</td>
                                                                                        <td>{{$numData->total_question}}</td>
                                                                                        <td>{{$answerCount}}</td>
                                                                                        <td>{{$numData->total_num}}</td>
                                                                                        <td>{{$answerNum}}</td>
                                                                                        <td>{{number_format($answerNum*100/$numData->total_num, 2, '.', ',')}} % </td> 
                                                                                        <td>P</td>
                                                                                </tr> 
                                                                            @elseif((($answerNum*100/$numData->total_num) < 37))
                                                                                <tr class="text-danger">
                                                                                        <td>{{$i++}}</td>
                                                                                        <td>{{$stdData->name}}</td>
                                                                                        <td>{{$stdData->email}}</td>
                                                                                        <td>{{$subData->sub_name}}</td>
                                                                                        <td>{{$examData->exam_title}}</td>
                                                                                        <td>{{$numData->total_question}}</td>
                                                                                        <td>{{$answerCount}}</td>
                                                                                        <td>{{$numData->total_num}}</td>
                                                                                        <td>{{$answerNum}}</td>
                                                                                        <td>{{number_format($answerNum*100/$numData->total_num, 2, '.', ',')}} % </td> 
                                                                                        <td>F</td>
                                                                                </tr> 
                                                                            @endif  
                                                                        @endif    
                                                                    @endforeach  
                                                                @endif
                                                            @endforeach        
                                                        @endif
                                                    @endforeach        
                                                @endif
                                            @endforeach        
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



@endsection

