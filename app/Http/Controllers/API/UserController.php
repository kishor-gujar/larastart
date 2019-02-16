<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use  App\User;
use Intervention\Image\ImageServiceProvider;

class UserController extends Controller
{
     public function __construct()
     {
         $this->middleware('auth:api');
     }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('isAdmin');
        return User::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
             'name'=>'required|string|max:191',
             'email'=>'required|string|email|max:191',
             'password'=>'required|string|max:191',
        ]);
        //
        return User::create([
            'name' =>$request['name'],
            'email' =>$request['email'],
            'type' =>$request['type'],
            'bio' =>$request['bio'],
            'photo' =>$request['photo'],
            'password' => Hash::make($request['password']),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|required|min:6'
        ]);
        $currentPhoto = $user->photo;
        if($request->photo != $currentPhoto){
            $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
            \Image::make($request->photo)->save(public_path('img/profile/').$name);
            $request->merge(['photo' => $name]);
            $userPhoto = public_path('img/profile/').$currentPhoto;
            if(file_exists($userPhoto)){
                @unlink($userPhoto);
            }
        }
        if(!empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);
        }
        $user->update($request->all());
        return ['message' => "Success"];
    }
    public function profile()
    {
        return auth('api')->user();
        //
    }
  
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //fi
        
        $user =User::findorFail($id);

        $this->validate($request,[
            'name'=>'required|string|max:191',
            'email'=>'required|string|email|max:191|unique:users,email,' .$user->id,
            'password'=>'sometimes|min:6',
       ]);
       
       $user->update($request->all());
       return['messege' => 'Update User'];

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $this->authorize('isAdmin');
        $user =User::findorFail($id);
        $user->delete();
        return ['message' =>'User Deleted'];

    }
}
