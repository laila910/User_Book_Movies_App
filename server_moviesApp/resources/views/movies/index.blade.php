
@extends('layouts.app');

@section('content')

<div class="container">
  @if(session('success'))
     <div class="alert alert-success mt-3">
        {{session('success')}}
     </div>
@endif
@isset($SearchPage)
<div class="alert alert-success mt-3">
  {{$SearchPage}}
</div>
@endisset
    


    <div class="card mt-3">
        <div class="card-body">
            <div class="d-flex">
                <h1>Movies <small class="text-muted">Showing All Movies</small></h1>
                <form class="m-3 form-inline" action="{{ route('movies.dashboard') }}" method="GET">
                  <div class="form-group">
                   @isset($search)
                    <input type="text" name="search" class="form-control" placeholder="Search on Movie :)" value="{{$search}}"/>
                  @else
                   <input type="text" name="search" class="form-control" placeholder="Search on Movie :)" />
                  @endisset
                  </div>
              </form> 
                <div class="m-auto">
                    <div class="dropdown">
                       <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         Export User-Movies
                       </button>
                       <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                         <a class="dropdown-item" href="{{route('movies.exportIntoExcel')}}">As Excel</a>   
                         <a class="dropdown-item" href="{{route('movies.exportIntoCSV')}}"> As CSV</a>
                       </div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Actions
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="{{route('movies.create')}}">Create New Movie</a>   
                          <a class="dropdown-item" href="{{route('movies.dashboard')}}">Return to movies dashboard</a>
                        </div>
                      </div>
                </div>
            </div>
          </div>
        </div>
           {{-- <hr> --}}
           @if($movies->count())
             @isset($search)
        {{-- {{$movies->links()}}  --}}
               @foreach ($movies as $movie)
                  @include('movies.movie-card',['movie'=>$movie]);
               @endforeach 
            @else 
              {{$movies->links()}}
 @foreach ($movies as $movie)
 @include('movies.movie-card',['movie'=>$movie]);
@endforeach

              @endisset
           @endif
         
        
       
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