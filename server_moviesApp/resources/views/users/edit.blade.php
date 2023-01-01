@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
      <div class="alert alert-success mt-3">
        {{session('success')}}
      </div>
    @endif
   <div class="card mt-3">
    <div class="card-body">
        <div class="d-flex">
            <h1>Edit User<small class="text-muted">{{$user->username}}</small></h1>
            <div class="m-auto">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Actions
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="{{route('users.dashboard')}}">View Users Dashboard</a>
                      <a class="dropdown-item" href="{{route('users.show',['user'=>$user->id])}}">View User</a>
                      <div class="dropdown-divider"></div>
                      <a href="#" class="dropdown-item text-danger" onclick="deleteUser()">Delete User</a> 
                      <form action="{{route('users.delete',$user->id)}}" id="delete-user-form" method='POST' style='display:none'>
                        @csrf
                        @method('DELETE')
                      </form>
                     
                    </div>
                  </div>
            </div>
        </div>
    </div>
   </div>
   <div class="row">
      <div class="col-sm-4">

         <div class="card mt-3">
            <div class="card-body">
                @if ($user->image)
                  <img src="{{asset('images/'.$user->image)}}" style='max-width:100%;max-height:100px' class="rounded" alt="">
                @else
                  <img src="{{asset('images/noUser.jpg')}}" style='max-width:100%;max-height:100px' class="rounded" alt="">
                @endif
                <hr>
                <button class="btn btn-outline-primary btn-sm btn-block" data-toggle='modal' data-target='#UpdateUserImage'>Upload New User Image</button>
                   @if($user->image)
                <button class="btn btn-outline-primary btn-sm btn-block" onclick="deleteUserImage()"><i class="fas fa-trash"></i>Delete User Image</button>
                   <form action="{{route('users.delete.userImage',$user->id)}}" method='POST' id="delete-user-image-form">
                      @csrf
                      @method('Delete')
                     
                    </form>
                  @endif
               
                
               
               
            </div>
         </div>
       
      </div>
      <div class="col-sm-8">
        <div class="card mt-3">
            <div class="card p-5">
               <h5>Edit User Details</h5>
               <hr>
               @if($errors->count())     
               <div class="alert alert-danger">
                   <ul>
                       @foreach ($errors->all() as $item)
                         <li>{{$item}}</li>
                       @endforeach
                   </ul> 
               </div>
               @endif
               <form action="{{route('users.update',$user->id)}}" method='POST' enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <div class="form-group mt-3 mb-3">
                      <label for="exampleInputName">User Name</label>
                      <input type="text" class='form-control' id='exampleInputName' name='username' placeholder="Enter User Name" value='{{$user->name}}'>
                  </div>
                  <div class="form-group mb-3">
                      <label for="exampleInputEmail">User Email</label>
                      <input type="email" class="form-control" id="exampleInputEmail"  name='email' placeholder="Enter Email" value='{{$user->email}}'>
                    </div>

                    <button type="submit" class="btn btn-primary">Update User Details</button>
                   
              </form>
             
            </div>
         </div>
    </div>

   </div>
  
</div>
<!-- Modal for updating Image -->
<div class="modal fade" id="UpdateUserImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update User Image</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{route('users.update.userImage',$user->id)}}" method='POST' enctype="multipart/form-data">
                @csrf
                @method('PUT')
                  <div class='form-group mb-3'> 
                    <label for="exampleFormControlImage">User Image</label>
                    <input type="file" class="form-control-file" id="exampleFormControlImage" name='image'>
                  </div>
                  <button type="submit" class="btn btn-primary">Update User Image</button>
            </form>
        </div>
      </div>
    </div>
  </div>

@endsection

@push('footer-scripts')
    <script>
        function deleteUserImage(){
            var r =confirm('Are you sure you want to delete the User Image?');
            if(r){
                document.querySelector('form#delete-user-image-form').submit();
            }
        }
        function deleteUser(){
            var r = confirm("Are you sure you want to delete this User? this can't be undone!");
            if(r){
                document.querySelector('form#delete-user-form').submit();
            }
        }
    </script>
@endpush