 @extends('teacher.app')
 @section('content')


        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                <div id="exancountdown"></div>
                
                <div>
                </div>
                
            </div>
           
            <!-- Content Row -->
            <div class="row">

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Exam</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="examCount"></div>
                                </div>
                                <div class="col-auto">
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                       Activate Exam</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="examActive"></div>
                                </div>
                                <div class="col-auto">
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Deactive Exam
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" id="examDeactive"></div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-auto">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Exam Completed</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="examDone"></div>
                                </div>
                                <div class="col-auto">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Row -->

        </div>
        <!-- /.container-fluid -->



@endsection

@section('timer-script')
<script>
    $(document).ready(function(){
        $.ajaxSetup
        ({
         headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
        });

        setInterval (function(){
        $.ajax({
            type: 'GET',
            url: 'fetch',
            dataType:'json',
            success: function(result)
            {
                // console.log(result.examCount);
                $('#examCount').html(result.examCount);
                $('#examActive').html(result.examCountActive);
                $('#examDeactive').html(result.examCountDeactive);
                $('#examDone').html(result.examDone);
                
            }    
          });
        },500);
    });
</script>
@endsection