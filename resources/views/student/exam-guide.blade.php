@extends('student.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9 offset-md-1 border ">
            <div id="examTimer" class="float-right font-weight-bold"></div>
            <div id="examEndTime" class="float-right font-weight-bold"></div>

        @foreach($exam as $examData)
             <p class="mt-5"> @foreach($subject as $subData)
                @if($examData->subject == $subData->id)
                     <b>{{$subData->sub_name}}</b>
                @endif
             @endforeach exam  title <b>{{$examData->exam_title}}</b> on date <b>"{{$examData->exam_date}}"</b> and time <b>"{{$examData->exam_time}}" is scheduled.</b></p>
             <p>There are {{$queCount}} questions</p>
             <label for="">Guidlines</label>
              <ul>
                <li>After start exam you will see time of end of this exam.</li>
                <li>There will be question and two button <b>previous</b> and <b>save & Next</b>.</li>
                <li>You need to select your answer and click <b>save & next</b> button.</li>
                <li>If you will think the previous answer is worng then you can go back by <b>previous</b> button and can change answer after change you need to click <b>save & next</b> button than the change will effect.</li>
                <li>You have to reach end of the question and click <b>save & next</b> then you will see other button <b>submit</b>.</li>
                <li>After complete your exam click on <b>submit</b> button.</li>
                <li>Due to some issue you are not able to reach end of the question and did not click on <b>sbumit</b> button your all answer will be save.</li>
                <li><b>Submit</b> button only for that examinee has completed his exam.</li>
                <li>Every answer will be save after click <b>save & next</b> button.</li>
                <li>If you have not complete your exam before reach end of the time then all question will gone only the asnwer which have you done that will be recorded and you will see a button <b>Back to home</b>.</li>
                <li><b>So best of luck.</b></li>
              </ul>             
             
             
             <input type="hidden" id="examD" value="{{$examData->exam_date}}">
             <input type="hidden" id="examT" value="{{$examData->exam_time}}">
             <input type="hidden" id="examFH" value="{{$examData->exam_hr}}">
             <input type="hidden" id="examFM" value="{{$examData->exam_min}}">
    
             <a href="{{ route('student.exam-start',['id'=>$examData->id])}}"><button class="btn btn-success" id="btnStart" style="display:none;">Start Exam</button></a>
             
             <a href="{{ route('student.home')}}"><button class="btn btn-success" id="btnHome" style="display:none;">Back</button></a>
         @endforeach
        
        </div>
    </div>
</div>
@endsection

@section('script')
<script>

// Set the date we're counting down to
var timeCount = document.getElementById("examD").value;
var dateCount = document.getElementById("examT").value;

// Set the date we're counting down to
var countDownDate = new Date(dateCount + ' ' + timeCount).getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  document.getElementById("examTimer").innerHTML ="Exam will start after :- "+ days + "d : " + hours + "h : "
  + minutes + "m : " + seconds + "s";
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("examTimer").innerHTML = "";
    document.getElementById('btnStart').style.display = "block";
    postTime();
     }
}, 1000);


function postTime(){
  var timeCount = document.getElementById("examD").value;
    var dateCount = document.getElementById("examT").value;
    var hr = document.getElementById("examFH").value;
    var min = document.getElementById("examFM").value;
   

    var dt3 = new Date(dateCount + ' ' + timeCount);
         dt3.setHours(dt3.getHours() + parseInt(hr));
         dt3.setMinutes(dt3.getMinutes() + parseInt(min));    
    

    // Set the date we're counting down to
    var countDownDate = new Date(dt3).getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

      // Get today's date and time
      var now = new Date().getTime();
    
      // Find the distance between now and the count down date
      var distance = countDownDate - now;
    
      // Time calculations for days, hours, minutes and seconds
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
      // Output the result in an element with id="demo"
      document.getElementById("examEndTime").innerHTML ="Exam will close after - "+ days + "d : " + hours + "h : "
      + minutes + "m : " + seconds + "s" ;
    
        // If the count down is over, write some text 
        if (distance < 0) {
          clearInterval(x);
          document.getElementById("examEndTime").innerHTML = "Exam Time Has Been Completed";
          document.getElementById('btnStart').style.display = "none";
          document.getElementById('btnHome').style.display = "block";
        
        }
      }, 1000);
}





</script>
@endsection