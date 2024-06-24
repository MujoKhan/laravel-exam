@extends('super.app')
@section('content')
   @if(session()->get('admin') == 1) 
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
            Admin
            <a href="#" data-toggle="modal" data-target="#modalForAddAdmin"><button class="btn btn-success float-right">Add Admin</button></a>
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
                          <th>Action</th>                          
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                        $i = 1;
                        @endphp
                        @foreach($admin as $adminData) 
                            <tr>
                                <td>{{ $i++}}</td>
                                <td>{{$adminData->name}}</td>
                                <td>{{$adminData->email}}</td>
                                <td>
                                  <button class="btn btn-success subupdate" data-toggle="modal" data-target="#updateAdmin{{$adminData->id}}" value="{{$adminData->id}}"><i class="fa-solid fa-pen-to-square"></i></button>
                                  <a href="{{route('super.trash',['id'=>$adminData->id, 'v'=>'trash admin'])}}"><button class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button></a>
                                </td>
                              
                                

                                <!-- update  subject-->
                                <!-- Modal For Update Course -->
                                <div class="modal fade myModal" id="updateAdmin{{$adminData->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog " role="document">
                                    <form class="refreshFrm" id="addCourseFrm" action="{{route('super.update-admin')}}" method="POST" >
                                        @csrf
                                    <div class="modal-content myModal-content" >
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Update</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="">Name</label>
                                                <input type="text" name="name" class="form-control" value="{{$adminData->name}}">
                                                @error('name')
                                                    <div class="aler alert-danger">{{$message}}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">Email</label>
                                                <input type="email" name="email" class="form-control" value="{{$adminData->email}}" readonly>
                                                @error('email')
                                                    <div class="aler alert-danger">{{$message}}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">Password</label>
                                                <input type="text" name="password" class="form-control" placeholder="If you want to change">
                                                @error('password')
                                                    <div class="aler alert-danger">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        
                                        <input type="hidden" name="admin_id" value="{{$adminData->id}}">
                                        <button type="submit" class="btn btn-primary">Update Now</button>
                                        </div>
                                    </div>
                                    </form>
                                    </div>
                                </div>
                                <!-- end update subject modal -->

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
          </div>
        </div>
      </div>
 </div>


  
<!-- Modal For Add admin -->
<div class="modal fade" id="modalForAddAdmin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
 <form action="{{route('super.add-admin')}}" method="POST">
   <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Add Admin</h5>
      
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    
      @csrf
    <div class="modal-body">
      <div class="col-md-12">
          <div class="form-group">
              <label for="">Name</label>
              <input type="text" name="name" value="{{old('name')}}" placeholder="Name" class="form-control">
              @error('name')
                <div class="aler alert-danger">{{$message}}</div>
              @enderror
          </div>
          <div class="form-group">
              <label for="">Email</label>
              <input type="email" name="email" value="{{old('email')}}" placeholder="Email" class="form-control">
              @error('email')
                <div class="aler alert-danger">{{$message}}</div>
              @enderror
          </div>
          <div class="form-group">
              <label for="">Password</label>
              <input type="password" name="password" value="{{old('password')}}" placeholder="Password" class="form-control">
              @error('password')
                <div class="aler alert-danger">{{$message}}</div>
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
<!-- end add admin modal -->

   @elseif(session()->get('permission') == 1) 
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
            Permission Admin
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
                          <th>Status</th>                       
                          <th>Action</th>   
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                        $i = 1;
                        @endphp
                        @foreach($admin as $adminData) 
                            <tr>
                                <td>{{ $i++}}</td>
                                <td>{{$adminData->name}}</td>
                                <td>{{$adminData->email}}</td>
                                @if($adminData->permission == 'No')
                                <td><i class="fa-solid fa-xmark text-danger"></i></td>
                                <td>
                                  <a href="{{route('super.allow',['id'=>$adminData->id, 'v'=>'allow admin'])}}"><button class="btn btn-success subupdate" ><i class="fa-solid fa-check"></i></button></a>
                                </td>
                                @else
                                <td><i class="fa-solid fa-check text-success"></i></td>
                                <td>
                                  <a href="{{route('super.allow',['id'=>$adminData->id, 'v'=>'block admin'])}}"><button class="btn btn-danger subupdate" ><i class="fa-solid fa-xmark"></i></button></a>
                                </td>
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
   @elseif(session()->get('trash') == 1) 
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
            Trash Admin
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
                          <th>Action</th>                          
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                        $i = 1;
                        @endphp
                        @foreach($admin as $adminData) 
                            <tr>
                                <td>{{ $i++}}</td>
                                <td>{{$adminData->name}}</td>
                                <td>{{$adminData->email}}</td>
                                <td>
                                  <a href="{{route('super.restore',['id'=>$adminData->id, 'v'=>'restore admin'])}}"><button class="btn btn-success subupdate" ><i class="fa-solid fa-trash-can-arrow-up"></i></button></a>
                                  <a href="{{route('super.restore',['id'=>$adminData->id, 'v'=>'delete admin'])}}"><button class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button></a>
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