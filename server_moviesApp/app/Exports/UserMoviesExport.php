<?php

namespace App\Exports;

use App\Models\UserMovie;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class UserMoviesExport implements FromCollection,WithHeadings
{

    

    public function headings():array{
        return [
           'Id',
           'User Name',
           'User Email',
           'Movie Name',
           'Movie Show Date & Time',
           'Movie Tickets Numbers'
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return UserMovie::all();
        return collect(UserMovie::getUsersMoviesTickets());
    }
}
