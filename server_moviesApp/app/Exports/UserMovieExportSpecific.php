<?php

namespace App\Exports;

use App\Models\UserMovie;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;


class UserMovieExportSpecific implements FromCollection,WithHeadings
{

    public $movieId;

    public function __construct($id=0) 
    {
        $this->movieId = $id;
    }

    public function headings():array{
        return [
           'Id',
           'User Name',
           'User Email',
           'Movie Show Date & Time',
           'Movie Tickets Numbers'
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $records=DB::table('user_movies')->join('users','user_movies.user_id','=','users.id')->join('movies','user_movies.movie_id','=','movies.id')->select('user_movies.id','users.username','users.email','user_movies.datetime','user_movies.ticketsNumbers')->where('user_movies.movie_id','=',$this->movieId)->get()->toArray();
        return collect($records);
    }
}
