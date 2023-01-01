<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\storeAndUpdateUserRequest;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::latest()->paginate(20);
        return view('users.index',['users'=>$users]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeAndUpdateUserRequest $request)
    {
        if($request->image){
            $image=time().'.'.$request->image->extension();  
            $request->image->move(public_path('images/'), $image);
        }else{
            $image=null;
        }

        User::create([
            'username'=>$request->username,
            'email'=>$request->email,
            'password'=>$request->password,
            'image'=>$image
          ]);
        return redirect()->route('users.dashboard')->with('success','Successfully created a New User');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show',compact('user'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit',compact('user'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(storeAndUpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
    
       
        return back()->with('success', 'Successfully updated User details!');
    }

    public function updateUserImage(storeAndUpdateUserRequest $request,User $user){
        if ($request->image) {
            $path=public_path('images/').$user->image;
            if(file_exists($path)){
                @unlink($path);
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/'), $imageName);
        }else{
            $imageName=$user->image;
        }
        $user->update([
            'image'=>$imageName
        ]);
        return back()->with('success','Successfully updated User image');
    }


    public function destroyUserImage(User $user){
        if($user->image){
            $path=public_path('public/').$user->image;
            @unlink($path);
            $user->update(['image'=>null]);
          }
          return back()->with('success','Successfuly Deleted User Image');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->image) {
            $path=public_path('public/').$user->image;
            @unlink($path);
         }
         $user->delete();
 
         return redirect()->route('users.dashboard')->with('success','Successfuly deleted User And All assets related to');
         
    }
}
