@extends('student.app')
@section('content')
@if(session()->get('exam') == 1)
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
                Current Exam Available
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
                                <th>Subject</th>
                                <th>Title</th>
                                <th>Date & Time</th>
                                <th>Teacher</th>
                                <th>Status</th>
                                <th>Exam</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @php
                            $i = 1;
                            @endphp
                            @foreach($examTime as $examdata)
                                        @if($examdata->exam_done == "No" )
                                            @foreach($clas as $clasdata)
                                                @if($examdata->class == $clasdata->id)
                                                    @foreach($subject as $subdata)
                                                        @if($examdata->subject == $subdata->id)
                                                            @foreach($teacher as $teacherData)
                                                                @if($teacherData->id == $examdata->teacher_id)
                                                                    <tr>
                                                                        <td>{{$i++}}</td>
                                                                        <td>{{$clasdata->class_name}}</td>
                                                                        <td>{{$subdata->sub_name}}</td>
                                                                        <td>{{$examdata->exam_title}}</td>
                                                                        <td><p>{{$examdata->exam_date}}, {{$examdata->exam_time}}</p></td>
                                                                        <td>{{$teacherData->email}}</td>
                                                                        <td>{{$examdata->exam_status}}</td>
                                                                        @if($examdata->exam_status == "Deactive")
                                                                            <td><button class="btn btn-success disabled">Wait...</button></td>
                                                                        @else
                                                                            <td><a href="{{ route('student.pre-exam',['id'=>$examdata->id])}}"><button class="btn btn-success">Start</button></a></td>
                                                                        @endif
                                                                    </tr>
                                                                @endif 
                                                            @endforeach       
                                                        @endif    
                                                    @endforeach    
                                                @endif
                                            @endforeach
                                        @endif  
                                    
                            @endforeach

                            <hr>
                        </tbody>
                    </table>
                
                </div>
            </div>
        </div>
    </div>
</div>

@elseif(session()->get('taken_exam') == 1)
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
                Exam Given and Submitted
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
                                <th>Subject</th>
                                <th>Title</th>
                                <th>Date & Time</th>
                                <th>Teacher</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            
                            @php
                            $i = 1;
                            @endphp
                            @foreach($examTime as $examdata)
                                            @foreach($clas as $clasdata)
                                                @if($examdata->class == $clasdata->id)
                                                    @foreach($subject as $subdata)
                                                        @if($examdata->subject == $subdata->id)
                                                            @foreach($teacher as $teacherData)
                                                                @if($teacherData->id == $examdata->teacher_id)
                                                                    <tr>
                                                                        <td>{{$i++}}</td>
                                                                        <td>{{$clasdata->class_name}}</td>
                                                                        <td>{{$subdata->sub_name}}</td>
                                                                        <td>{{$examdata->exam_title}}</td>
                                                                        <td><p>{{$examdata->exam_date}}, {{$examdata->exam_time}}</p></td>
                                                                        <td>{{$teacherData->email}}</td> 
                                                                    </tr>
                                                                @endif 
                                                            @endforeach       
                                                        @endif    
                                                    @endforeach    
                                                @endif
                                            @endforeach                                    
                            @endforeach

                            <hr>
                        </tbody>
                    </table>
                
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary">
            <div>
                Exam Given But Not Submit
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table id="example2" class="table table-striped table-bordered dt-responsive nowrap editTable"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>S.NO.</th>
                                <th>Class</th>
                                <th>Subject</th>
                                <th>Title</th>
                                <th>Date & Time</th>
                                <th>Teacher</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            
                            @php
                            $i = 1;
                            @endphp
                            @foreach($examTimeNotSubmit as $examdata)
                                            @foreach($clas as $clasdata)
                                                @if($examdata->class == $clasdata->id)
                                                    @foreach($subject as $subdata)
                                                        @if($examdata->subject == $subdata->id)
                                                            @foreach($teacher as $teacherData)
                                                                @if($teacherData->id == $examdata->teacher_id)
                                                                    <tr>
                                                                        <td>{{$i++}}</td>
                                                                        <td>{{$clasdata->class_name}}</td>
                                                                        <td>{{$subdata->sub_name}}</td>
                                                                        <td>{{$examdata->exam_title}}</td>
                                                                        <td><p>{{$examdata->exam_date}}, {{$examdata->exam_time}}</p></td>
                                                                        <td>{{$teacherData->email}}</td>
                                                                        
                                                                       
                                                                    </tr>
                                                                @endif 
                                                            @endforeach       
                                                        @endif    
                                                    @endforeach    
                                                @endif
                                            @endforeach                                   
                            @endforeach

                            <hr>
                        </tbody>
                    </table>
                
                </div>
            </div>
        </div>
    </div>
</div>
@elseif(session()->get('not_taken_exam') == 1)
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
                Exam Not Given
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
                                <th>Subject</th>
                                <th>Title</th>
                                <th>Date & Time</th>
                                <th>Teacher</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @php
                            $i = 1;
                            @endphp
                            @foreach($examTime as $examdata)
                                            @foreach($clas as $clasdata)
                                                @if($examdata->class == $clasdata->id)
                                                    @foreach($subject as $subdata)
                                                        @if($examdata->subject == $subdata->id)
                                                            @foreach($teacher as $teacherData)
                                                                @if($teacherData->id == $examdata->teacher_id)
                                                                    <tr>
                                                                        <td>{{$i++}}</td>
                                                                        <td>{{$clasdata->class_name}}</td>
                                                                        <td>{{$subdata->sub_name}}</td>
                                                                        <td>{{$examdata->exam_title}}</td>
                                                                        <td><p>{{$examdata->exam_date}}, {{$examdata->exam_time}}</p></td>
                                                                        <td>{{$teacherData->email}}</td>
                                                                
                                                                    </tr>
                                                                @endif 
                                                            @endforeach       
                                                        @endif    
                                                    @endforeach    
                                                @endif
                                            @endforeach                                    
                            @endforeach

                            <hr>
                        </tbody>
                    </table>
                
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('script')
@endsection