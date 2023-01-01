<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\storeAndUpdateMovieRequest;
use App\Http\Requests\StoreAndUpdateMovieShow;
use App\Http\Requests\storeAndUpdateUserMovie;
use Illuminate\Http\Request;
use App\Services\MovieQuery;
use App\Models\Movie;
use App\Models\MovieShowtime;
use App\Http\Resources\V1\MoviesResource;
use App\Http\Resources\V1\MovieResource;
use App\Exports\UserMoviesExport;
use App\Exports\UserMovieExportSpecific;
use Excel;
use PDF;
use App\Models\UserMovie;
use Illuminate\Support\Facades\DB;



class MovieApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter=new MovieQuery();
        $queryItems=$filter->transform($request);
        if(count($queryItems)==0){
            return MoviesResource::collection(Movie::paginate());
        }
        else{
            return MoviesResource::collection(Movie::where($queryItems)->paginate());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeAndUpdateMovieRequest $request)
    {
        if($request->image){
            $image=time().'.'.$request->image->extension();  
            $request->image->move(public_path('images/'), $image);
        }else{
            $image=null;
        }
        Movie::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'type'=>$request->type,
            'image'=>$image,
            'ticketPrice'=>$request->ticketPrice
          ]);
        return 'Successfully Movie Created :)';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movie=Movie::find($id)->first();
     
        $arr=array();
        $movieShowTimes=MovieShowtime::where('movie_id',$movie->id)->get()->toArray();

        for ($i=0; $i <count($movieShowTimes) ; $i++) { 
            $data['DateOfShow']=$movieShowTimes[$i]['date'];
            $data['TimeOfShow']=$movieShowTimes[$i]['time'];
            $data['NumberOfTickets']=$movieShowTimes[$i]['numberOfTickets'];
            $data['NumberOfReservedTickets']=$movieShowTimes[$i]['numberOfTicketsReserved'];
            array_push($arr,(object)$data);
        }
        $movie->extra=(object) ['arr'=>$arr];
        return new MovieResource($movie); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(storeAndUpdateMovieRequest $request,$id)
    {
        $movie=Movie::find($id)->first;
        if ($request->image) {
            $path=public_path('images/').$movie->image;
            if(file_exists($path)){
                @unlink($path);
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/'), $imageName);
        }else{
            $imageName=$movie->image;
        }
         $movie->update([
            'name' => $request->name,
            'description' => $request->description,
            'type'=>$request->type,
            'ticketPrice'=>$request->ticketPrice,
            'image' => $imageName,
        ]);  
        return 'Successfully Updated Movie :)';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        if ($movie->image) {
            $path=public_path('images/').$movie->image;
            @unlink($path);
         }
           $movie->delete();
           return 'successfully deleted Movie';
    }

    public function addmovieShowTime(StoreAndUpdateMovieShow $request,Movie $movie){
        $movie_id=$movie->id;
        $date=$request->date;
        $time=$request->time;
       
           MovieShowtime::updateOrCreate([
             'movie_id'=>$movie_id,
            'date'=>$date,'time'=>$time]);
     
        return 'Successfully Added Movie Show Time to this Movie';
    }
    public function bookTicket(storeAndUpdateUserMovie $request,$id){
        $movie=Movie::find($id)->first();
        $arrayTicketsNumber=array();
        $ticketsNumbers=$request->ticketsNumbers;
        for ($i=0; $i < $ticketsNumbers ; $i++) { 
            array_push($arrayTicketsNumber,time());
        }
        UserMovie::updateOrCreate([
            'user_id'=>$request->user_id,
            'movie_id'=>$movie->id],[
            'ticketsNumbers'=>$arrayTicketsNumber,
            'datetime'=>$request->datetime
        ]);
        $arrayOfDateTime=explode('@',$request->datetime);
        $date=$arrayOfDateTime[0];
        $time=trim($arrayOfDateTime[1]);
        $movieShowTime=MovieShowtime::where('date','=',$date)->where('time','=',$time)->where('movie_id','=',$movie->id)->first();
        $movieShowTime->numberOfTicketsReserved +=$ticketsNumbers;
        $movieShowTime->save();
        return 'successfully booked tickets :)';

    }
   
    public function exportIntoExcel(){
        return  Excel::download(new UserMoviesExport,'UserMovielist.xlsx');
    }

    public function exportIntoCSV(){
        return Excel::download(new UserMoviesExport,'UserMovielist.csv');
   }

   public function exportExcel($id){
    $movie=Movie::find($id)->first();

    $filename='movie_'.$movie->name.'.xlsx';
    return Excel::download(new UserMovieExportSpecific($movie->id),$filename);
    }

    public function exportCSV($id){
        $movie=Movie::find($id)->first();

        $filename='movie_'.$movie->name.'.csv';
        return Excel::download(new UserMovieExportSpecific($movie->id),$filename);
    }

    public function DownloadPDF($id){
        $movie=Movie::find($id)->first();
        $records= DB::table('user_movies')->join('users','user_movies.user_id','=','users.id')->join('movies','user_movies.movie_id','=','movies.id')->select('user_movies.id','users.username','users.email','user_movies.datetime','user_movies.ticketsNumbers')->where('user_movies.movie_id','=',$movie->id)->get()->toArray();
        $pdf=PDF::loadView('movies.pdf',compact('records'))->setOptions(['defaultFont' => 'sans-serif']);
        $filename='movie_'.$movie->name.'.pdf';
        return $pdf->download($filename);
     }

   
}
