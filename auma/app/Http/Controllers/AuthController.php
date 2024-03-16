<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Resources\AuthResource;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseApiController;

class AuthController extends BaseApiController
{
    public function __construct(private UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $data = $this->formatMany($this->userRepository->all(), 'App\Http\Resources\AuthResource');
        return response()->json($data);
    }

    public function userRegister(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'cpassword' => 'required|same:password',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        $data['role'] = 'user';
        $data['password'] = Hash::make($data['password']);

        $user = $this->userRepository->create($data);

        $data = AuthResource::transformer($user);

        return response()->json(['user_id' => $user->id], 201);
    }

    public function adminRegister(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'cpassword' => 'required|same:password',
        ]);

        $data['role'] = 'admin';
        $data['password'] = Hash::make($data['password']);

        $user = $this->userRepository->create($data);

        $data = AuthResource::transformer($user);

        return response()->json(['user_id' => $user->id], 201);
    }

    public function teacherRegister(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'cpassword' => 'required|same:password',
            'link' => 'required|url:http,https',
        ]);

        $data['password'] = Hash::make($data['password']);

        $user = Teacher::create($data);

        return response()->json(['user_id' => $user->id], 201);
    }

    public function searchTeacher($name)
    {
        $teacher = Teacher::where('name', "like", "%" . $name . "%")->get();
        return response()->json($teacher);
    }

    public function login(Request $request): Response
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $success = $user->createToken('MyApp')->plainTextToken;
            return response(['token' => $success], 200);
        } else {
            return response(['message' => 'Invalid credentials'], 401);
        }
    }

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
                $data['body'] = "Please click on the link below to reset your password.";

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

                return response()->json(['success' => true, 'msg' => 'Please check your email to reset your password.']);
            } else {
                return response()->json(['success' => false, 'msg' => 'User not found.']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function resetPasswordLoad(Request $request)
    {
        $resetData = PasswordReset::where('token', $request->token)->get();
        if (isset($request->token) && count($resetData) > 0) {
            $user = User::where('email', $resetData[0]['email'])->get();
            return view('resetPassword', compact('user'));
        } else {
            return view('404');
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed'
        ]);
        $user = User::find($request->id);
        $user->password =  Hash::make($request->password);
        $user->save();
        PasswordReset::where('email', $user->email)->delete();
        return view('success');
    }

    public function emailupdate(Request $request, $id)
    {
        $data = Validator::make($request->all(), [
            'email' => 'required|email',
            'confirm_email' => 'required|email|same:email',
            'password' => 'required',
            'id' => 'required'
        ])->validate();

        $user = $this->userRepository->find($id);
        $data['id'] = $id;
        $credentials = $request->only('id', 'password');

        if (Auth::attempt($credentials)) {
            $request->except(['confirm_email', 'password', 'id']);
            $this->userRepository->update($data, $user);

            return $this->success(
                $this->formatMany(
                    $this->userRepository->all(),
                    'App\Http\Resources\AuthResource'
                ),
                'Updated Successfully',
                201
            );
