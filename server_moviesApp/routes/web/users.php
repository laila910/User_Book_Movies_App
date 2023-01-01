<?php 
use App\Http\Controllers\UserController;

Route::get('/',[UserController::class,'index'])->name('dashboard');//name: users.dashboard
Route::get('create',[UserController::class,'create'])->name('create'); //name : users.create
Route::get('{user}/edit',[UserController::class,'edit'])->name('edit');//name : users.edit
Route::get('{user}',[UserController::class,'show'])->name('show');//name: users.show
Route::post('/',[UserController::class,'store'])->name('store');//name: users.store
Route::put('{user}',[UserController::class,'update'])->name('update');//name: users.update
Route::put('{user}/user-image',[UserController::class,'updateUserImage'])->name('update.userImage');//name: users.update.userImage
Route::delete('{user}',[UserController::class,'destroy'])->name('delete');//name: users.delete
Route::delete('{user}/user-image',[UserController::class,'destroyUserImage'])->name('delete.userImage');//name: users.delete.userImage
