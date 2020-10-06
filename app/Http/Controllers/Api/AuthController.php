<?php

namespace app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SignUpRequest;
use Laravel\Passport\Client as OClient; 
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
class AuthController extends Controller
{
    /**
     * @OA\Post(
     ** path="/v1/user-login",
     *   tags={"Login"},
     *   summary="Login",
     *   operationId="login",
     *
     *   @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Correo electrónico o contraseña incorrectos"
     *   )
     *)
     **/
    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request){
        $validator = User::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)){
            return response()->json([
                'message' => 'Correo electrónico o contraseña incorrectos'
            ], 401);
        }
        $oClient = OClient::where('password_client', 1)->first();
        return $this->getTokenAndRefreshToken($oClient,request('email'), request('password'));
    }


    /**
     * @OA\Post(
     ** path="/v1/user-register",
     *   tags={"Sign Up"},
     *   summary="Sign Up",
     *   operationId="sign up",
     *
     *  @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="lastname",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *       name="cellphone",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *      @OA\Parameter(
     *      name="password_confirmation",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *     @OA\Parameter(
     *      name="department_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *   @OA\Response(
     *      response=201,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Invalid Data"
     *   )
     *)
     **/
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function signup(SignUpRequest $request){
        $validator = User::make($request->all(), [
            'name' => 'required',
            'lastname'=>'required',
            'email' => 'required|email|unique:users',
            'cellphone' => 'required|unique',
            'password' => 'required|confirmed',
            'department_id' => 'required' 
        ]);
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $user = User::create($data);

        $user->assignRole('Estudiante');
        $user->save();
        return $this->login($request);
    }


    /**
     * @OA\Post(
     ** path="/v1/user-logout",
     *   tags={"Login"},
     *   summary="Login",
     *   operationId="login",
     *
     *   @OA\Parameter(
     *      name="token",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Response(
     *      response=203,
     *       description="Cierre de sesion correcto",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *  @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *  )
     *)
     **/
    /**
     * logout api
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Cierre se sesión correcto'
        ],203);
    }
    
    public function getTokenAndRefreshToken($oClient,$email,$password){
        $http = new Client;

        $response = $http->request('POST', 'http://localhost:3180/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $oClient->id,
                'client_secret' => $oClient->secret,
                'username' => $email,
                'password' => $password,
                'scope' => '*',
            ],
        ]);
        $result = json_decode((string) $response->getBody(), true);
        $user = Auth::user();
        $user->roles;
        return response()->json([
            'authaccess'=>$result,
            'user' => $user
        ]);
    }

    /**
     * @OA\GET(
     ** path="/v1/me",
     *   tags={"Login"},
     *   summary="Login",
     *   operationId="login",
     *  @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *  @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *   )
     * )
     */
    /**
     * me api
     *
     * @return \Illuminate\Http\Response
     */
    public function me(){
        return response()->json([
            'user' => request('user')
        ],200);
    }
}