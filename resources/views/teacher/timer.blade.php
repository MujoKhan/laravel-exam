<script>

// Set the date we're counting down to
var timeCount = document.getElementById("examTimeCount").value;
var dateCount = document.getElementById("examDateCount").value;

// new timers
// 2022-02-27 05:34:54
// var countDownDate = new Date(Date.parse(dateCount + ' ' + timeCount)); 

//   var x = setInterval(function() {
//   const total = Date.parse(countDownDate) - Date.parse(new Date());
//   const seconds = Math.floor( (total/1000) % 60 );
//   const minutes = Math.floor( (total/1000/60) % 60 );
//   const hours = Math.floor( (total/(1000*60*60)) % 24 );
//   const days = Math.floor( total/(1000*60*60*24) );
//   document.getElementById("exancountdown").innerHTML = +days + "d : " + hours + "h : "
//   + minutes + "m : " + seconds + "s";
//   if(total < 0)
//   {
//     document.getElementById("exancountdown").innerHTML = "Time Up";
//     document.getElementById('addExamQueBtn').style.display = "none";
//   }
// }, 1000);


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
  document.getElementById("exancountdown").innerHTML = days + "d : " + hours + "h : "
  + minutes + "m : " + seconds + "s";
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("exancountdown").innerHTML = "Time Up";
    document.getElementById('addExamQueBtn').style.display = "none";
  }
}, 1000);
</script>

<!-- select class -->


<!-- select class -->