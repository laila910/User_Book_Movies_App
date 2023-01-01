
<div class='container'>
    
<div class="card mt-3">
    <div class="card-body">
         <div class="row">
            <div class="col-sm-3 col-md-2">
            </div>
            @foreach($records as $record)
            <div class="col-sm-6">
               
                <ul>
                    <li>
                        <strong>Record Id: </strong>{{$record->id}}
                    </li>
                    <li>
                        <strong>User Name :</strong> {{$record->username}}
                    </li>
                    <li>
                        <strong>User Email: </strong>{{$record->email}}
                    </li>
                    <li>
                        <strong>Movie Show Date @ Time:</strong> {{$record->datetime}} 
                    </li>
                    <li>
                        <strong>Movie Tickets Numbers: </strong> {{$record->ticketsNumbers}}
                    </li>
                </ul>
                <hr>
            </div>
          
            @endforeach
         </div>
    </div>
</div>
</div>
