<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $table='movies';

    protected $fillable=[
        'name',
        'description',
        'type',
        'image',
        'ticketPrice'
    ];

    public function getPrettyCreatedAttribute(){
        return date('F d, Y',strtotime($this->created_at));
    }
    
    public function users(){
        $this->belongsToMany(User::class,'user_movies');
    }
  
    public function showtimes(){
        $this->hasMany(MovieShowTime::class,'movie_showtimes');
    }
}
