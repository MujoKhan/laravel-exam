@extends('admin.app')
@section('content')

    @if(session()->get('class') == 1)
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
                Class
                <a href="#" data-toggle="modal" data-target="#modalForAddclass"><button class="btn btn-success float-right">Add Class</button></a>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                    <table id="example" class="table table-striped table-bordered dt-responsive nowrap editTable" style="width:100%">
                        <thead>
                            <tr>
                              <th>S.NO.</th>
                              <th>Class</th>   
                              <th>action</th>                   
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                            $i = 1;
                            @endphp
                            @foreach($class as $classData) 
                                <tr>
                                    <td>{{ $i++}}</td>
                                    <td>{{$classData->class_name}}</td>
                                    <td>
                                      <button class="btn btn-success subupdate" data-toggle="modal" data-target="#updateClass{{$classData->id}}" value="{{$classData->id}}"><i class="fa-solid fa-pen-to-square"></i></button>
                                      <a href="{{route('admin.trash',['id'=>$classData->id, 'v'=>'trash class'])}}"><button class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button></a>
                                    </td>
                                  
                                    
    
                                    <!-- update  subject-->
                                    <!-- Modal For Update teacher -->
                                    <div class="modal fade myModal" id="updateClass{{$classData->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog " role="document">
                                        <form class="refreshFrm" id="addCourseFrm" action="{{route('admin.update-class')}}" method="POST" >
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
                                                    <label for="">Class</label>
                                                    <input type="text" name="class" class="form-control" value="{{$classData->class_name}}">
                                                    @error('class')
                                                        <div class="aler alert-danger">{{$message}}</div>
                                                    @enderror
                                                </div>
                                               
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            
                                            <input type="hidden" name="class_id" value="{{$classData->id}}">
                                            <button type="submit" class="btn btn-primary">Update Now</button>
                                            </div>
                                        </div>
                                        </form>
                                        </div>
                                    </div>
                                    <!-- end update teacher modal -->
    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
              </div>
            </div>
          </div>
     </div>
    
    
      
    <!-- Modal For Add class -->
    <div class="modal fade" id="modalForAddclass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
     <form action="{{route('admin.add-class')}}" method="POST">
       <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Class</h5>
          
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
          @csrf
        <div class="modal-body">
          <div class="col-md-12">
              <div class="form-group">
                  <label for="">Class</label>
                  <input type="text" name="class" value="{{old('class')}}" placeholder="Class" class="form-control">
                  @error('class')
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
    <!-- end add class modal -->

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
                Trash Class
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                    <table id="example" class="table table-striped table-bordered dt-responsive nowrap editTable" style="width:100%">
                        <thead>
                            <tr>
                              <th>S.NO.</th>
                              <th>Class</th>   
                              <th>action</th>                   
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                            $i = 1;
                            @endphp
                            @foreach($class as $classData) 
                                <tr>
                                    <td>{{ $i++}}</td>
                                    <td>{{$classData->class_name}}</td>
                                    <td>
                                        <a href="{{route('admin.trash',['id'=>$classData->id, 'v'=>'restore class'])}}"><button class="btn btn-success"><i class="fa-solid fa-trash-can-arrow-up"></i></button></a>
                                        <a href="{{route('admin.trash',['id'=>$classData->id, 'v'=>'delete class'])}}"><button class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button></a>
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