<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\storeAndUpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\V1\UsersResource;
use Illuminate\Support\Facades\Hash;

class UserApiController extends Controller
{

    public function register(RegisterUserRequest $request){
        if($request->image){
            $image=time().'.'.$request->image->extension();  
            $request->image->move(public_path('images/'), $image);
        }else{
            $image=null;
        }     

        $user=User::create([
           'username'=>$request->username,
           'email'=>$request->email,
           'password'=>bcrypt($request->password),
           'image'=>$image
        ]);

        $token=$user->createToken('myapptoken')->plainTextToken;
        $response=[
           'user'=>$user,
           'token'=>$token
        ];

        return response($response,201); 

    }

    public function login(LoginUserRequest $request){
        //check email
        $user=User::where('email',$request->email)->first();
        //check password
        if(!$user || !Hash::check($request->password,$user->password)){
            return response(['message'=>'bad creditionals'],401);
        }

        $token=$user->createToken('myapptoken')->plainTextToken;
        $response=[
           'user'=>$user,
           'token'=>$token
        ];

        return response($response,201); 

    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        return [
          'message'=>'Logged Out'
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UsersResource::collection(User::paginate());
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UsersResource($user);
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
    public function update(storeAndUpdateUserRequest $request,User $user)
    {
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
        if($request->password){
            $request->merge(['password' => Hash::make($request->password)]);
            $user->update([
                'username' => $request->username,
                'email' => $request->email,
                'image' => $imageName,
                'password'=>$user->password
            ]);
        }else{
         $user->update([
              'username' => $request->username,
              'email' => $request->email,
              'image' => $imageName,
              'password'=>$request->password
          ]);
       } 
        return 'Successfully Updated User :)';
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
            $path=public_path('images/').$user->image;
            @unlink($path);
         }
           $user->delete();
           return 'successfully deleted User';
    }
}
