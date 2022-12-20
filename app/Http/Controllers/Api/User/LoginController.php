<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use App\Http\Requests\User\LoginUserRequest;

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
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password Anda Salah !!!'
            ], 401);
        }

        // if auth successful
        return response()->json([
            'success'   => true,
            'user'      =>auth()->guard('api')->user(),
            'token'     => $token
        ], 200);
    }
}
