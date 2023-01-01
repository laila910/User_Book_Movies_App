@extends('layouts.app');

@section('content')
<div class="container">
    <div class="card mt-3">
        <div class="card-body">
            <div class="d-flex">
                <h1>Create Movie</h1>
                <div class="m-auto">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Actions
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="{{route('movies.dashboard')}}">view Movies Dashboard</a>
                        </div>
                      </div>
                </div>
            </div>
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

          
            <form action="{{route('movies.store')}}" method='POST' enctype="multipart/form-data">
                @csrf
                <div class="form-group mt-3 mb-3">
                    <label for="exampleInputname">Name</label>
                    <input type="text" class='form-control' id='exampleInputname' name='name' placeholder="Enter Movie Name">
                </div>
                <div class="form-group mb-3">
                    <label for="exampleInputEmail">Description</label>
                    <input type="text" class="form-control" id="exampleInputdescription"  name='description' placeholder="Enter Description">
                  </div>
                  <div class="form-group mb-3">
                    <label for="exampleType">Type</label>
                    <select name="type" class="form-control"style="width:400px" id="exampleType">
                        <option>Choose your Movie Type</option>
                        <option value="action">Action</option>
                        <option value="adventure">Adventure</option>
                        <option value="comedy">Comedy</option>
                        <option value="drama">Drama</option>
                        <option value="horror">Horror</option>
                        <option value="romance">Romance</option>
                        <option value="fiction">Fiction</option>
                        <option value="fantasy">Fantasy</option>
                        <option value="Historical">historical</option>
                        <option value="crime">Crime</option>
                      </select>
                    </div>
                 
                 
                  <div class="form-group mb-3">
                    <label for="examplePrice">Ticket Price</label>
                    <input type="number" name="ticketPrice" id="examplePrice">
                  </div>
                  
                  <div class='form-group mb-3'> 
                    <label for="exampleImage">Movie Image</label>
                    <input type="file" class="form-control-file" id="exampleFormControlImage" name='image'>
                  </div>
              
                  <button type="submit" class="btn btn-primary float-right">Create Movie</button>
            </form>
            
        </div>
    </div>
</div>

@endsection