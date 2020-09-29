<?php

namespace app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SignUpRequest;
use Laravel\Passport\Client as OClient; 
use GuzzleHttp\Client;

class AuthController extends Controller
{
    public function login(Request $request){
        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)){
            return response()->json([
                'message' => 'Correo electrónico o contraseña incorrectos'
            ], 401);
        }
        $oClient = OClient::where('password_client', 1)->first();
        return $this->getTokenAndRefreshToken($oClient,request('email'), request('password'));
        // $user = $request->user();
        // $tokenResult = $user->createToken('Personal Access Token');

        // $token = $tokenResult->token;
        // $token->save();

        // return response()->json([
        //     $tokenResult,
        //     'access_token' => $tokenResult->accessToken,
        //     'token_type' => 'Bearer',
        //     'user' => $user
        // ]);
    }

    public function signup(SignUpRequest $request){
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return $this->login($request);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Cierre se sesión correcto'
        ],203);
    }

    public function getTokenAndRefreshToken($oClient,$email,$password){
        $http = new GuzzleHttp\Client;

        $response = $http->request('POST', 'http://localhost:8000/oauth/token', [
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
        return response()->json($result, $this->successStatus);
    }
}
