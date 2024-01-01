<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthResourse;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Repositories\User\UserRepository;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseApiController;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;


class AuthController extends BaseApiController
{
    // الووو
    // i am here 
    /**
     * Display a listing of the resource.
     */

     public function __construct(private UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function index()
    {
        return $this->success(
            $this->formatMany(
                $this->userRepository->all(),
                'App\Http\Resources\AuthResourse'
            ),
            "categories retreived succssefully",
            200
        );

    }

    /**
     * Store a newly created resource in storage.
     */
    public function userRegister(Request $request)
    {
            $data = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required' // we must make valdation ya 3abdooooo
                
                
              ]);
              $data['role'] = 'user' ; 
              $data['password'] = Hash::make($data['password']);


            $user = $this->userRepository->create($data);

            $data = AuthResourse::transformer($user);
            
            return $this->success($data,"Created successfully",201);
    }

    public function adminRegister(Request $request)
    {
   
            $data = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required' 
                  
              ]);
              $data['role'] = 'admin' ; 
              $data['password'] = Hash::make($data['password']);
    
            $user = $this->userRepository->create($data);

            $data = AuthResourse::transformer($user);
            
            return $this->success($data,"Created successfully",201);
    }

    public function teacherRegister(Request $request){
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required', // we must make valdation ya 3abdooooo
            'social_link' => 'required|url:http,https'           
          ]);
          $data['role'] = 'teacher' ; 
          $data['password'] = Hash::make($data['password']);

        $user = $this->userRepository->create($data);

        $data = AuthResourse::transformer($user);
        
        return $this->success($data,"Created successfully",201);
    }


public function login(Request $request)
{

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        return response()->json(['massege'=> 'you are signed in'],200);
    } else {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }
}
    

    // public function passwordupdate(Request $request, $id)
    // {
    //     $data = Validator::make($request->all(), [
    //         'password' => 'required', // why we need title for user ?
    //         'confirm_password' => 'required', 

    //         ])->safe()->all();
    // $user = $this->userRepository->find($id);

    
    // $data =  $this->userRepository->update($data,$user);
  
 
    
    // return $this->success($this->formatMany(
    //     $this->userRepository->all(),
    // 'App\Http\Resources\AuthResourse'),
    // 'Updated Succesfully',201);

    // }    
    
    // de 3ysen n3mlaha bel email zy el 2nta 3mlto 

    public function emailupdate(Request $request, $id)
    {
        $data = Validator::make($request->all(), [
            'email' => 'required|email', // why we need title for user ?
            'confirm_email' => 'required|email|same:email', 
            'password' => 'required',
            'id' => 'required'
            ])->validate();

            $user = $this->userRepository->find($id);
            $credentials = $request->only('id','password');
            $data['id'] = $id;
            
            if(Auth::attempt($credentials)){
                $request->except(['confirm_email','password','id']);
                $this->userRepository->update($data,$user);
  
 
    
        return $this->success($this->formatMany(
        $this->userRepository->all(),
        'App\Http\Resources\AuthResourse'),
        'Updated Succesfully',201);
    }else {
        return $this->error('Wrong input');
    }
    }

    public function destroy($id)
    {
        $user = $this->userRepository->find($id);
        $this->userRepository->delete($user);
        return $this->success($this->formatMany(
            $this->userRepository->all(),
        'App\Http\Resources\userResourse'),
        'Updated Succesfully',201);
    }
}
