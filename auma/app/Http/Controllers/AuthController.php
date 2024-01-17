<?php

namespace App\Http\Controllers;

use to;
use App\Models\User;
use App\Models\Course;
use App\Models\Teacher;
// use App\Models\PasswordReset;
// use App\Models\PasswordReset;
use PharIo\Manifest\Url;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Resources\AuthResourse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Auth\UserProvider;
use App\Http\Controllers\API\BaseApiController;

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
        // return $this->success(
        //     $this->formatMany(
        //         $this->userRepository->all(),
        //         'App\Http\Resources\AuthResourse'
        //     ),
        //     "categories retreived succssefully",
        //     200
        // );
        $data = $this->formatMany($this->userRepository->all(), 'App\Http\Resources\AuthResourse');
        return response()->json($data);
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

            return response()->json(['user_id' => $user->id], 201);
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

            return response()->json(['user_id' => $user->id], 201);
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

        return response()->json(['user_id' => $user->id], 201);
    }

    //search  teacher

    function searchteacher($name)
    {
        $teacher = Teacher::where('name',"like","%".$name."%")->get();
        return response()->json( $teacher);

    }


public function login(Request $request)
{

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        return response()->json(['user_id' => $user->id], 201);
    } else {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }
}


// public function login(Request $request)
// {
//     $credentials = $request->only('email', 'password');

//     if (Auth::attempt($credentials)) {
//         $user = Auth::user();
//         return response()->json(['user_id' => $user->id], 201);
//     } else {
//         return response()->json(['message' => 'Invalid credentials'], 401);
//     }
// }


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


    // reset password ya gamed






    public function forgetPassword(Request $request)
{
    try {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $token = Str::random(40);

            $domain = url('/');
            $url = $domain . '/reset-password?token=' . $token;

            $data['url'] = $url;
            $data['email'] = $request->email;
            $data['title'] = "Password Reset";
            $data['body'] = "Please click on the link below to reset your password ya 3amm";

            Mail::send('forgetPasswordMail', ['data' => $data], function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });

            $datetime = Carbon::now()->format('Y-m-d H:i:s');

            PasswordReset::updateOrCreate(
                ['email' => $request->email],
                [
                    'email' => $request->email,
                    'token' => $token,
                    'created_at' => $datetime
                ]
            );

            return response()->json(['success' => true, 'msg' => 'Please check your email to reset your password ya 3amm']);
        } else {
            return response()->json(['success' => false, 'msg' => 'User not found ya 3amm']);
        }
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'msg' => $e->getMessage()]);
    }






}

      //reset password load

      public function resetPasswordLoad(Request $requset){

         $resetData = PasswordReset::where('token' , $requset->token)->get();
          if (isset($requset->token) && count( $resetData) > 0) {

           $user = User::where('email',$resetData[0]['email'])->get();

           return view('resetPassword' ,compact('user'));

          } else {
             return view('404');
          }





      }

      //password Reset
      public function resetPassword(Request $requset){
          $requset->validate([
             'password' => 'required|string|min:8|confirmed'
          ]);
          $user =User::find($requset->id);
          $user->password =  Hash::make($requset->password);
          $user->save();
         PasswordReset::where('email' ,$user->email)->delete();


           return "<h1>Your Password Reset Successfully Y 3ammmmmmm </h1>";

      }



    public function emailupdate(Request $request, $id)
    {
        $data = Validator::make($request->all(), [
            'email' => 'required|email', // why we need title for user ?
            'confirm_email' => 'required|email|same:email',
            'password' => 'required',
            'id' => 'required'
            ])->validate();

            $user = $this->userRepository->find($id);
            $data['id'] = $id;
            $credentials = $request->only('id','password');

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

    // public function getcousebyteachername(Request $request)
    // {
    //     $categoryName = $request->input('title');

    //     $category = Course::query();

    //     if ($categoryName) {
    //         $category->join('categories', 'categories.id', '=', 'courses.user_id')
    //         ->where('categories.title', $categoryName);
    //     }

    //     $filteredcategory = $category->get();

    //     return response()->json(['category' => $filteredcategory]);
    // }

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
