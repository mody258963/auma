<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // الووو
    // i am here 
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        return response()->json($user);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function userRegister(Request $request)
    {
            // TODO: make request for validate this request 
            // or use Validator::make($request->all,[
            // your rules 
            // ]) 
            $data = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required'
              ]);
              // TODO use repository
              // we don't need direct call eloquent
          $user = User::create($data);
            // you can refactor this to avoid redandancy 
            // i mean make function named success in parent class of controller and inhert from this class 
            // revision last session 

          return response()->json(['message'=> "User has been successfully registered!",$user],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // TODO use repository desgin pattern 
        // also you make direct call to eloquent 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // TODO use repository to find model and make request to validate data
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //TODO use repository 
    }
}
