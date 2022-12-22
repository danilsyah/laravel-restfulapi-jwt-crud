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

     /**
     * @OA\Post(
     *      path="/api/register",
     *      operationId="register",
     *      tags={"User"},
     *      summary="Register a user",
     *      description="Returns user data",
     *       @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(@OA\Examples(example="registerUser", summary="Register new user",value={"name":"string", "email":"example@mail.com", "password":"string", "password_confirmation":"string"})),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/ResponseResource")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
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
