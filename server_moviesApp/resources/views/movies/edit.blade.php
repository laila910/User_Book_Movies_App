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
            <h1>Edit Movie<small class="text-muted">{{$movie->name}}</small></h1>
            <div class="m-auto">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Actions
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="{{route('movies.dashboard')}}">View Movies Dashboard</a>
                      <a class="dropdown-item" href="{{route('movies.show',['movie'=>$movie->id])}}">View Movie</a>
                      <div class="dropdown-divider"></div>
                      <a href="#" class="dropdown-item text-danger" onclick="deleteMovie()">Delete Movie</a> 
                      <form action="{{route('movies.delete',$movie->id)}}" id="delete-movie-form" method='POST' style='display:none'>
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
                @if ($movie->image)
                  <img src="{{asset('images/'.$movie->image)}}" style='max-width:100%;max-height:100px' class="rounded" alt="">
                @else
                  <img src="{{asset('images/NoMovie.png')}}" style='max-width:100%;max-height:100px' class="rounded" alt="">
                @endif
                <hr>
                <button class="btn btn-outline-primary btn-sm btn-block" data-toggle='modal' data-target='#UpdateMovieImage'>Upload New Movie Image</button>
                   @if($movie->image)
                <button class="btn btn-outline-primary btn-sm btn-block" onclick="deleteMovieImage()"><i class="fas fa-trash"></i>Delete Movie Image</button>
                   <form action="{{route('movies.delete.movieImage',$movie->id)}}" method='POST' id="delete-movie-image-form">
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
               <h5>Edit Movie Details</h5>
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
               <form action="{{route('movies.update',$movie->id)}}" method='POST' enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <div class="form-group mt-3 mb-3">
                      <label for="exampleInputName">Movie Name</label>
                      <input type="text" class='form-control' id='exampleInputName' name='name' placeholder="Enter Movie Name" value='{{$movie->name}}'>
                  </div>
                  <div class="form-group mb-3">
                      <label for="exampleInputDescription">Movie Description</label>
                      <input type="text" class="form-control" id="exampleInputDescription"  name='description' placeholder="Enter Description" value='{{$movie->description}}'>
                    </div>
                    <div class="form-group mb-3">
                        <label for="exampleType">Type</label>
                        <select name="type" class="form-control"style="width:400px" id="exampleType">
                            <option>Choose your Movie Type</option>
                            <option @if($movie->type=='action') selected  @endif value="action">Action</option>
                            <option @if($movie->type =='adventure') selected @endif value="adventure">Adventure</option>
                            <option @if($movie->type=='comedy') selected  @endif value="comedy">Comedy</option>
                            <option @if($movie->type=='drama') selected  @endif value="drama">Drama</option>
                            <option @if($movie->type=='horror') selected @endif value="horror">Horror</option>
                            <option @if($movie->type=='romance') selected  @endif value="romance">Romance</option>
                            <option @if($movie->type=='fiction') selected  @endif  value="fiction">Fiction</option>
                            <option @if($movie->type=='fantasy') selected  @endif  value="fantasy">Fantasy</option>
                            <option @if($movie->type=='Historical') selected  @endif  value="Historical">historical</option>
                            <option @if($movie->type=='crime') selected  @endif  value="crime">Crime</option>
                          </select>

                    </div>

                    <div class="form-group mb-3">
                       <label for="examplePrice">Ticket Price</label>
                       <input type="number" name="ticketPrice" id="examplePrice" value="{{$movie->ticketPrice}}">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Movie Details</button>
                   
              </form>
             
            </div>
         </div>
    </div>

   </div>
  
</div>
<!-- Modal for updating Image -->
<div class="modal fade" id="UpdateMovieImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update Movie Image</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{route('movies.update.movieImage',$movie->id)}}" method='POST' enctype="multipart/form-data">
                @csrf
                @method('PUT')
                  <div class='form-group mb-3'> 
                    <label for="exampleFormControlImage">Movie Image</label>
                    <input type="file" class="form-control-file" id="exampleFormControlImage" name='image'>
                  </div>
                  <button type="submit" class="btn btn-primary">Update Movie Image</button>
            </form>
        </div>
      </div>
    </div>
  </div>

@endsection

@push('footer-scripts')
    <script>
        function deleteMovieImage(){
            var r =confirm('Are you sure you want to delete the Movie Image?');
            if(r){
                document.querySelector('form#delete-movie-image-form').submit();
            }
        }
        function deleteMovie(){
            var r = confirm("Are you sure you want to delete this Movie? this can't be undone!");
            if(r){
                document.querySelector('form#delete-movie-form').submit();
            }
        }
    </script>
@endpush