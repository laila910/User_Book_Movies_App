<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class UserMovie extends Model
{
    use HasFactory;

    protected $table='user_movies';

    protected $fillable=[
        'user_id',
        'movie_id',
        'datetime',
      
        'ticketsNumbers'
    ];
    public function getPrettyCreatedAttribute(){
        return date('F d, Y',strtotime($this->created_at));
    }
    protected $casts=[
        'ticketsNumbers'=>'array'
    ];

    public function getUsersMoviesTickets(){
        $records=DB::table('user_movies')->join('users','user_movies.user_id','=','users.id')->join('movies','user_movies.movie_id','=','movies.id')->select('user_movies.id','users.username','users.email','movies.name','user_movies.datetime','user_movies.ticketsNumbers')->get()->toArray();
        return $records;
    }
}
