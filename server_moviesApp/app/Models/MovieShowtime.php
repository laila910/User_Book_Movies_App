<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieShowtime extends Model
{
    use HasFactory;

    protected $table='movie_showtimes';

    protected $fillable=[
        'date',
        'time',
        'numberOfTickets',
        'numberOfTicketsReserved',
        'movie_id'
    ];
    public function getPrettyCreatedAttribute(){
        return date('F d, Y',strtotime($this->created_at));
    }
    public function movie(){
        $this->belongsTo(Movie::class);
    }
}
