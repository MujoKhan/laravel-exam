@extends('student.app')
@section('content')
@section('style')
<style>
    
</style>
@endsection
<div class="conatiner" id="allHome" style="display:none">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h5>Time has been completed. So you cant change or give exam.</h5>
            <a href="{{route('student.home')}}"><button class="btn btn-success">Back To Home</button></a>
        </div>
    </div>
</div>
<div class="container" id="all">
    <div class="row">
        <div class="col-md-7 offset-md-4">
            <div id="examTime" class="float-right font-weight-bold"></div>
            <div id="q" class="font-weight-bold"></div>
            <div id="ques" class="font-weight-bold mb-3 mt-5"></div>
            <div id="radio">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" value="opt1" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1" id="op1"></label>                    
                    
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" value="opt2" id="flexRadioDefault2">
                        <label class="form-check-label" for="flexRadioDefault2" id="op2" ></label>
                    
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" value="opt3" id="flexRadioDefault3">
                        <label class="form-check-label" for="flexRadioDefault3" id="op3" ></label>
                    
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" value="opt4" id="flexRadioDefault4">
                        <label class="form-check-label" for="flexRadioDefault4" id="op4" ></label>
                    
                </div>
            </div>            
        </div>
    </div>
    <div class="d-flex justify-content-around">
                <div id="btn1"></div>
                <div id="btn2"></div>
                <div >
                    <form action="{{ route('student.exam-submit')}}" method="POST">
                        @csrf
                        <input type="hidden" name="examId" value="{{ session()->get('examId') }}">
                        <input type="hidden" name="stdId" value="{{ Auth::guard('student')->user()->id }}">
                        <button type="submit" class="btn btn-success" id="btn3" style="display:none">Submit</button>
                    </form>
                </div>
    </div>

</div>
<hr>


@endsection

@section('script')
<script>

   
    // this is laravel object with quot
     var ar = "{{ $question }}";
    //  remove quot and store in varibale which is array
     var totalQues = JSON.parse(ar.replace(/&quot;/g,'"'));
     var queMaxSize = "{{ $queCount }}";
     var examId = "{{ session()->get('examId') }}";
     
     
     var queCount = 1;
     var queMinSize = 1;

     var p = document.getElementById('p');
     var n = document.getElementById('n');
    // console.log(c);
    
    show(queCount);

    function back()
    {
        if(queCount > queMinSize)
        {
            queCount--;
            document.getElementById('ques').innerHTML = 1;
            document.getElementById('btn3').style.display = "none";
            document.getElementById('btn2').style.display = "block";
            show(queCount);
            
        }        
    }

    function next()
    {
        if(queCount < queMaxSize)
        {
            queCount++;
            document.getElementById('ques').innerHTML = 1;
            show(queCount);
        }
        else if(queCount == queMaxSize)
        {
            document.getElementById('btn2').style.display = "none";
            document.getElementById('btn3').style.display = "block";
        }
    }

    function show(queCount)
    {
           // that array print with his column
        totalQues.forEach(function (value, i) 
        {
            var a = i+1;

            
            if(a == queCount)
            {
            
                document.getElementById('ques').innerHTML = "Ques " + a + "):- " +value.question;
                document.getElementById('op1').innerHTML = value.opt1;
                document.getElementById('op2').innerHTML = value.opt2;
                document.getElementById('op3').innerHTML = value.opt3;
                document.getElementById('op4').innerHTML = value.opt4;
                document.getElementById('btn1').innerHTML = '<button class="btn btn-success" onclick="back();" id="p">Previou</button>';
                document.getElementById('btn2').innerHTML = '<button class="btn btn-success" onclick="next();" id="n" value=" '+value.id+' ">Save & Next</button>';
                document.getElementById('q').innerHTML = " Total - "+ queCount+ " / " +queMaxSize;
                
            }
        });
        
    }




    var examHr = "{{ session()->get('hr') }}";
     var examMin = "{{ session()->get('min') }}";
     var dt = "{{ session()->get('date') }}";
     var tm = "{{ session()->get('time') }}";
     var newDate = new Date();

    var dt2 = new Date(dt + ' ' + tm);
         dt2.setHours(dt2.getHours() + parseInt(examHr));
         dt2.setMinutes(dt2.getMinutes() + parseInt(examMin));    
    

// Set the date we're counting down to
var countDownDate = new Date(dt2).getTime();

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
  document.getElementById("examTime").innerHTML = days + " : " + hours + " : "
  + minutes + " : " + seconds ;
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("examTime").innerHTML = "Time Up";
    document.getElementById("all").style.display = "none";
    document.getElementById("allHome").style.display = "block";
   
  }
}, 1000);


// ajax
$(document).ready(function(){

   $.ajaxSetup
        ({
         headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
        });

        var option;
        $('input[type="radio"]').click(function(){
            option = $(this).val();
        });
        $(document).on('click','#n', function(e){
            var queId = $(this).val();  
            var data ={
                'option': option,
                'queId' : queId,
                'examId': examId,
            };
                $.ajax({
                    url: '{{Route('student.que')}}',
                    type: 'POST',
                    data: data,
                    dataType:'json',
                    success: function(result)
                    {
                        console.log(result.game);
                    }    
                });
            
        });
});

</script>
@endsection