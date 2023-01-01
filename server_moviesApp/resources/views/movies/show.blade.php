@extends('layouts.app')

@section('content')
<div class='container'>
  @if(session('success'))
  <div class="alert alert-success mt-3">
     {{session('success')}}
  </div>
@endif
<div class="card mt-3">
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
                        <strong>Movie Name :</strong> {{$movie->name}}
                    </li>
                    <li>
                        <strong>Date Added: </strong>{{$movie->pretty_created}}
                    </li>
                    <li>
                        <strong>Movie Description:</strong> {{$movie->description}} 
                    </li>
                    <li>
                        <strong>Movie Type: </strong> {{$movie->type}}
                    </li>
                    <li>
                      <strong>Ticket Price: </strong>{{$movie->ticketPrice}} EGP
                    </li>
                    <li>
                      <strong>Movie Show Time:</strong>   
                      <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#BookTicket">
                        Book
                      </button> 
                     <a href="{{route('movies.exportExcel',['movie'=>$movie->id])}}" class="btn btn-info">Export Excel All Reserved Tickets</a>
                     <a href="{{route('movies.exportCSV',['movie'=>$movie->id])}}" class="btn btn-success">Export CSV All Reserved Tickets</a>
                     <a href="{{route('movies.DownloadPDF',['movie'=>$movie->id])}}" class="btn btn-warning">Export PDF All Reserved Tickets</a>
                      <br>
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Time</th>
                           <th scope="col">Number Of Tickets</th>
                           <th scope="col">Number Of Reserved Tickets</th>
                          
                          
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($movieShowTimes as $showtime)
                          <tr>
                            <th scope="row">{{$showtime->date}}</th>
                              <td>{{$showtime->time}}</td>
                              <td>{{$showtime->numberOfTickets}}</td>
                              <td>{{$showtime->numberOfTicketsReserved}}</td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
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
                      {{-- <button type="button" class="dropdown-item btn btn-primary" data-toggle="modal" data-target="#PriceModal">
                        Add New Price of Pharmacy
                      </button>  --}}
                    
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
</div>
@endsection



<!-- Modal -->
<div class="modal fade" id="BookTicket" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create New Movie Show Time</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form  action="{{route('movies.bookTicket',['movie'=>$movie->id])}}" method="POST" enctype="multipart/form-data">
              @csrf

              <div class="form-group mt-3 mb-3">
                  <label for="exampleInputTickets">Movie Tickets Number</label>
                  <input type="number" class='form-control' id='exampleInputTickets' name='ticketsNumbers' placeholder="Enter Number Of Tickets You want" >
              </div>
             
              <div class="form-group mb-3">
                <label for="exampleDate">Movie Date & Time</label>
                <select name="datetime" class="form-control" style="width:400px" id="exampleType">
                    <option>Choose your Movie Date & Time</option>
                    @foreach($movieShowTimes as $showtime)
                      <option value="{{$showtime->date}}@ {{$showtime->time}}">{{$showtime->date}} @ {{$showtime->time}}</option>
                   @endforeach
                  </select>
                </div>
                <button type="submit" class="btn btn-primary">Book Movie Tickets</button>
          </form>
      </div>
      
    </div>
  </div>
</div>
{{-- end Modal --}}
@push('footer-scripts')
    <script>
        function deleteMovie(){
            var r = confirm("Are you sure you want to delete this Movie? this can't be undone!");
            if(r){
                document.querySelector('form#delete-movie-form').submit();
            }
        }
    </script>
@endpush