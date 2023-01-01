<?php 
use App\Http\Controllers\MovieController;
// Export All Movies Into Excel
Route::get('exportIntoExcel',[MovieController::class,'exportIntoExcel'])->name('exportIntoExcel');//name: movies.exportIntoExcel
// Export All Movies Into CSV
Route::get('exportIntoCSV',[MovieController::class,'exportIntoCSV'])->name('exportIntoCSV');//name: movies.exportIntoCSV
// Export Specific User-Movie Details into Excel
Route::get('{movie}/exportExcel',[MovieController::class,'exportExcel'])->name('exportExcel');//name:movies.exportExcel
// Export Specific User-Movie Details into CSV
Route::get('{movie}/exportCSV',[MovieController::class,'exportCSV'])->name('exportCSV');//name: movies.exportCSV
// Export Specific User-Movie Details into Pdf
Route::get('{movie}/DownloadPDF',[MovieController::class,'DownloadPDF'])->name('DownloadPDF');//name: movies.DownloadPDF
Route::get('/',[MovieController::class,'index'])->name('dashboard');//name: movies.dashboard
Route::get('create',[MovieController::class,'create'])->name('create'); //name : movies.create
Route::get('{movie}/edit',[MovieController::class,'edit'])->name('edit');//name : movies.edit
Route::get('{movie}',[MovieController::class,'show'])->name('show');//name: movies.show
Route::post('/',[MovieController::class,'store'])->name('store');//name: movies.store
Route::put('{movie}',[MovieController::class,'update'])->name('update');//name: movies.update
Route::put('{movie}/movie-image',[MovieController::class,'updateMovieImage'])->name('update.movieImage');//name: movies.update.movieImage
Route::delete('{movie}',[MovieController::class,'destroy'])->name('delete');//name: movies.delete
Route::delete('{movie}/movie-image',[MovieController::class,'destroyMovieImage'])->name('delete.movieImage');//name: movies.delete.movieImage
// Add Movie ShowTime to Specific Movie
Route::post('{movie}/addmovieShowTime',[MovieController::class,'addmovieShowTime'])->name('addmovieShowTime');//name: movies.addmovieShowTime
// Book A ticket for Specific Movie
Route::post('{movie}/bookTicket',[MovieController::class,'bookTicket'])->name('bookTicket')->middleware('auth');//name: movies.bookTicket
