<div class="card mt-3 user-card">
    <div class="card-body">
         <div class="row">
            <div class="col-sm-3 col-md-2">
               @if ($user->image)
                <img src="{{asset('images/'.$user->image)}}" style='max-width:100%;max-height:100px' class="rounded" alt="">
               @else
               <img src="{{asset('images/noUser.jpg')}}" style='max-width:100%;max-height:100px' class="rounded" alt="">
               @endif
            </div>
            <div class="col-sm-6">
                <h5>{{$user->name}}</h5>
                <ul>
                    <li>
                        <strong>User Name:</strong> {{$user->username}}
                    </li>
                    <li>
                        <strong>Date Added: </strong>{{$user->pretty_created}}
                    </li>
                    <li>
                        <strong>User Email: </strong>{{$user->email}}
                    </li>
                  
                </ul>
            </div>
            <div class="col-sm-3">
                <div class="dropdown d-block">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Actions
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="{{route('users.edit',['user'=>$user->id])}}">Edit User</a>
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

