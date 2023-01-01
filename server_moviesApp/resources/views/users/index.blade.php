
@extends('layouts.app');

@section('content')

<div class="container">
  @if(session('success'))
     <div class="alert alert-success mt-3">
        {{session('success')}}
     </div>
@endif
{{-- @isset($SearchPage)
<div class="alert alert-success mt-3">
  {{$SearchPage}}
</div>
@endisset --}}
    


    <div class="card mt-3">
        <div class="card-body">
            <div class="d-flex">
                <h1>Users <small class="text-muted">Showing All Users</small></h1>
                {{-- <form class="m-3 form-inline" action="{{ route('users.dashboard') }}" method="GET">
                  <div class="form-group">
                   @isset($search)
                    <input type="text" name="search" class="form-control" placeholder="Search on Product :)" value="{{$search}}"/>
                  @else
                   <input type="text" name="search" class="form-control" placeholder="Search on Product :)" />
                  @endisset
                  </div>
              </form> --}}
                <div class="m-auto">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Actions
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="{{route('users.create')}}">Create New User</a>   
                          {{-- <a class="dropdown-item" href="{{route('users.dashboard')}}">Return to users dashboard</a> --}}
                        </div>
                      </div>
                </div>
            </div>
          </div>
        </div>
           {{-- <hr> --}}
           @if($users->count())
             {{-- @isset($search) --}}
           {{-- {{$products->links()}} --}}
               {{-- @foreach ($products as $product)
                  @include('products.product-card',['product'=>$product,'pharmacies'=>$pharmacies]);
               @endforeach --}}
              {{-- @else --}}
              {{$users->links()}}
 @foreach ($users as $user)
 @include('users.user-card',['user'=>$user]);
@endforeach

              {{-- @endisset --}}
           @endif
         
        
       
</div>

@endsection


@push('footer-scripts')
    <script>
       
        function deleteUser(){
            var r = confirm("Are you sure you want to delete this User? this can't be undone!");
            if(r){
                document.querySelector('form#delete-user-form').submit();
            }
        }
    </script>
@endpush