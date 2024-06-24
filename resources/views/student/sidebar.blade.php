<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('student.home')}}">
    <div class="sidebar-brand-icon rotate-n-15">
        <i class="fa-solid fa-graduation-cap"></i>  
    </div>
    <div class="sidebar-brand-text mx-3">{{Auth::guard('student')->user()->name}}<sup>Student</sup></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="{{route('student.home')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Interface
</div>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="{{route('student.task',['v'=>'available exam'])}}">
        <i class="fas fa-fw fa-cog"></i>
        <span>Available Exam's</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link collapsed" href="{{route('student.task',['v'=>'taken exam'])}}">
        <i class="fas fa-fw fa-cog"></i>
        <span>Taken Exam's</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link collapsed" href="{{route('student.task',['v'=>'not taken exam'])}}">
        <i class="fas fa-fw fa-cog"></i>
        <span>Not Taken Exam's</span>
    </a>
</li>



<!-- Divider -->
<hr class="sidebar-divider">



<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>


</ul>
<!-- End of Sidebar -->
