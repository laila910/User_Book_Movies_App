<div class="card mt-3 movie-card">
    <div class="card-body">
         <div class="row">
            <div class="col-sm-3 col-md-2">
               @if ($movie->image)
                <img src="{{asset('images/'.$movie->image)}}" style='max-width:100%;max-height:100px' class="rounded" alt="">
               @else
               <img src="{{asset('images/NoMovie.png')}}" style='max-width:100%;max-height:100px' class="rounded" alt="">
               @endif
            </div>
            <div class="col-sm-6">
                <h5>{{$movie->name}}</h5>
                <ul>
                    <li>
                        <strong>Movie Name:</strong> {{$movie->name}}
                    </li>
                    <li>
                        <strong>Date Added: </strong>{{$movie->pretty_created}}
                    </li>
                    <li>
                        <strong>Movie Description: </strong>{{$movie->description}}
                    </li>
                    <li>
                        <strong>Movie Type: </strong>{{$movie->type}}
                    </li>
                    <li>
                      <strong>Ticket Price: </strong>{{$movie->ticketPrice}} EGP
                    </li>
                    
                  
                </ul>
            </div>
            <div class="col-sm-3">
                <div class="dropdown d-block">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Actions
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="{{route('movies.edit',['movie'=>$movie->id])}}">Edit Movie</a>
                      <a class="dropdown-item" href="{{route('movies.show',['movie'=>$movie->id])}}">View Movie</a>
                      <button type="button" class="dropdown-item btn btn-primary" data-toggle="modal" data-target="#MovieShowTimeModal">
                        Add New Movie Show Time 
                      </button> 
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

<!-- Modal -->
<div class="modal fade" id="MovieShowTimeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create New Movie Show Time</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form  action="{{route('movies.addmovieShowTime',['movie'=>$movie->id])}}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="form-group mt-3 mb-3">
                  <label for="exampleInputDate">Movie Show Date</label>
                  <input type="date" class='form-control' id='exampleInputDate' name='date' placeholder="Enter Movie Show Date" >
              </div>
              <div class="form-group mt-3 mb-3">
                <label for="exampleInputTime">Movie Show Time</label>
                <input type="time"  class='form-control' id='exampleInputTime' name='time' placeholder="Enter Movie Show Time" >
            </div>
              
                <button type="submit" class="btn btn-primary">Create Movie Show Time</button>
          </form>
      </div>
      
    </div>
  </div>
</div>
{{-- end Modal --}}