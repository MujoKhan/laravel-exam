@extends('admin.app')
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
                                    Total Admin</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="adminCount"></div>
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
                                   Total Teacher</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="teacherCount"></div>
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
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Student
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" id="studentCount"></div>
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
                                    Total Class</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="classCount"></div>
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
        url: '{{Route('admin.fetch')}}',
        dataType:'json',
        success: function(result)
        {
            // console.log(result.examCount);
            $('#adminCount').html(result.adminCount);
            $('#teacherCount').html(result.teacherCount);
            $('#studentCount').html(result.studentCount);
            $('#classCount').html(result.classCount);
            
        }    
      });
    },500);
});
</script>
@endsection
