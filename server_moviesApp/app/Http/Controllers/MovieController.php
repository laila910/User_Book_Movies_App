<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Requests\storeAndUpdateMovieRequest;
use App\Models\MovieShowtime;
use App\Http\Requests\StoreAndUpdateMovieShow;
use App\Http\Requests\storeAndUpdateUserMovie;
use App\Models\UserMovie;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\UserMoviesExport;
use Excel;
use PDF;
use App\Exports\UserMovieExportSpecific;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get the search value from the request
        if($request->input('search')){
          $search = $request->input('search');
 
         // Search in the name and description columns from the movies table
           $movies = Movie::query()
             ->where('name', 'LIKE', "%{$search}%")
             ->orWhere('description', 'LIKE', "%{$search}%")
             ->get();
             return view('movies.index',['movies'=>$movies,'search'=>$search,'SearchPage'=>'You are in the search page, return to Movies dashboard to see all Movies :) ']);
 
         
        }else if($request->input('search')==null){
         $movies=Movie::latest()->paginate(20);
         return view('movies.index',['movies'=>$movies]);
        }
        // $movies=Movie::latest()->paginate(20);
        // return view('movies.index',['movies'=>$movies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('movies.create');

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
        return redirect()->route('movies.dashboard')->with('success','Successfully created a New Movie');

    }
    public function addmovieShowTime(StoreAndUpdateMovieShow $request,Movie $movie){
       
        $movie_id=$movie->id;
        $date=$request->date;
        $time=$request->time;
       
           MovieShowtime::updateOrCreate([
             'movie_id'=>$movie_id,
            'date'=>$date,'time'=>$time]);
     
        return redirect()->route('movies.dashboard')->with('success','Successfully Added Movie Show Date and Time To This Movie');
        
    }

    public function bookTicket(storeAndUpdateUserMovie $request,Movie $movie){
        $arrayTicketsNumber=array();
        $ticketsNumbers=$request->ticketsNumbers;
        for ($i=0; $i < $ticketsNumbers ; $i++) { 
            array_push($arrayTicketsNumber,time());
        }
        UserMovie::updateOrCreate([
            'user_id'=>Auth::user()->id,
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
        return back()->with('success','successfully booked tickets :)');
    }

  
    public function exportIntoExcel(){
     return  Excel::download(new UserMoviesExport,'UserMovielist.xlsx');

    }

    public function exportIntoCSV(){
         return Excel::download(new UserMoviesExport,'UserMovielist.csv');
    }

    public function exportExcel(Movie $movie){
        $filename='movie_'.$movie->name.'.xlsx';
        return Excel::download(new UserMovieExportSpecific($movie->id),$filename);

    }
    public function exportCSV(Movie $movie){
        $filename='movie_'.$movie->name.'.csv';
        return Excel::download(new UserMovieExportSpecific($movie->id),$filename);
    }
    public function DownloadPDF(Movie $movie){
       $records= DB::table('user_movies')->join('users','user_movies.user_id','=','users.id')->join('movies','user_movies.movie_id','=','movies.id')->select('user_movies.id','users.username','users.email','user_movies.datetime','user_movies.ticketsNumbers')->where('user_movies.movie_id','=',$movie->id)->get()->toArray();
       $pdf=PDF::loadView('movies.pdf',compact('records'))->setOptions(['defaultFont' => 'sans-serif']);
       $filename='movie_'.$movie->name.'.pdf';
       return $pdf->download($filename);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
       $movieShowTimes=MovieShowtime::where('movie_id',$movie->id)->get();
        return view('movies.show',compact('movie','movieShowTimes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
        return view('movies.edit',compact('movie'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(storeAndUpdateMovieRequest $request, Movie $movie)
    {
        $movie->update($request->validated());
    
       
        return back()->with('success', 'Successfully updated Movie details!');
    }

    public function updateMovieImage(storeAndUpdateMovieRequest $request,Movie $movie){
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
            'image'=>$imageName
        ]);
        return back()->with('success','Successfully updated Movie image');
    }

    public function destroyMovieImage(Movie $movie){
        if($movie->image){
          $path=public_path('public/').$movie->image;
          @unlink($path);
          $movie->update(['image'=>null]);
        }
        return back()->with('success','Successfuly Deleted Movie Image');
      }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        if ($movie->image) {
            $path=public_path('public/').$movie->image;
            @unlink($path);
         }
         $movie->delete();
 
         return redirect()->route('movies.dashboard')->with('success','Successfuly deleted Movies And All assets related to');
         
    }
}
