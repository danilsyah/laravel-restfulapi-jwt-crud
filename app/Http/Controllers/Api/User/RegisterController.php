<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use App\Http\Requests\User\RegisterUserRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(RegisterUserRequest $request)
    {
        // create user
        $user = User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password' => bcrypt($request->password)
        ]);

        // return response JSON user is created
        if($user){
            return response()->json([
                'success' => true,
                'user' => $user
            ], 201);
        }

        // return JSON process insert failed
        return response()->json([
            'success'=>false,
        ], 409);
    }
}
