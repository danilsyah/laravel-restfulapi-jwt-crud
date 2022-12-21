<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Resources\ResponseResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(LoginUserRequest $request)
    {
        // get credentials from request
        $credentials = $request->only('email', 'password');

        // if auth failed
        if(!$token = auth()->guard('api')->attempt($credentials)){
            return response()->json(new ResponseResource(false, 'Email atau Password Anda Salah!!!', null), 401);
        }

        // if auth successful
        $user = [
            'user' =>auth()->guard('api')->user(),
            'token' => $token
        ];

        return response()->json(new ResponseResource(true, 'Login Successfuly', $user), 200);
    }

    public function getUser(Request $request){
        return response()->json(new ResponseResource(true, 'Data User', $request->user()), 200);
    }
}
