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
    public function __construct()
    {
        $this->middleware('checkauth')->only('me','logout');    
    }

    /**
     * @OA\Post(
     ** path="/api/auth/login",
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
     *       description="Correo electrónico o contraseña incorrectos",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *  )
     *)
     **/
    /**
     * login api
     *
     * @return \Illuminate\Http\Response
    */
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
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
     ** path="/api/auth/signup",
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
     *      name="program_id",
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
     *      response=422,
     *       description="Error: Unprocessable Entity",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *  )
     *)
     **/
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function signup(SignUpRequest $request){
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $user = User::create($data);

        $user->assignRole('Estudiante');
        $user->save();
        return $this->login($request);
    }


    /**
     * @OA\GET(
     ** path="/api/auth/logout",
     *   tags={"Logout"},
     *   summary="Logout",
     *   operationId="logout",
     *   security={{"bearerAuth":{}}},
     *   @OA\Response(
     *      response=203,
     *       description="Cierre de sesion correcto",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="El token de autenticación expiró | Token de autenticacion invalido",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *    )
     * )
     * 
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

        $response = $http->request('POST', 'http://localhost:3190/oauth/token', [
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
        $user-> seedlings;
        return response()->json([
            'authaccess'=>$result,
            'user' => $user
        ]);
    }

    /**
     * @OA\GET(
     ** path="/api/auth/me",
     *   tags={"Me"},
     *   summary="Me",
     *   operationId="me",
     *   security={{"bearerAuth":{}}},
     *  @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="El token de autenticación expiró | Token de autenticacion invalido",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *    )
     * )
     */
    /**
     * me api
     *
     * @return \Illuminate\Http\Response
     */
    public function me(){
        $user = Auth::user();
        $user->roles;
        $user->seedlings->load('group');
        $user->groups;
        return response()->json([
            'user' => $user
        ],200);
    }

    /**
    * @OA\Get(
    *     path="/api/auth/refresh",
    *     summary="Refresh token",
    *     @OA\Response(
    *         response=200,
    *         description="Auth access tokens",
    *         @OA\MediaType(
    *           mediaType="application/json",
    *         )
    *     ),
    *     @OA\Response(
    *         response="401",
    *         description="Invalid verification token",
    *         @OA\MediaType(
    *           mediaType="application/json",
    *         )
    *     ),
    * )
    */
    public function refreshToken(Request $request){
        $request->validate([
            'refresh_token' => 'required'
        ],[
            'refresh_token.required' => 'El token para refrescar es obligatorio'
        ]);

        $http = new Client;
        $oClient = OClient::where('password_client', 1)->first();

        $response = $http->post('http://localhost:3190/oauth/token', [
            'form_params' => [
                'grant_type' => 'refresh_token',
                'refresh_token' => $request->refresh_token,
                'client_id' => $oClient->id,
                'client_secret' => $oClient->secret,
                'scope' => '',
            ],
        ]);
        
        $tokenDecoded = json_decode((string) $response->getBody(), true);
        
        if ($tokenDecoded) {
            return response()->json([
                'authaccess' => $tokenDecoded
            ],200);
        }else{
            return response()->json([
                'message' => 'Token de verificación invalido',
                'code' => 'invalid_refresh_token'
            ],401);
        }
    }
}
