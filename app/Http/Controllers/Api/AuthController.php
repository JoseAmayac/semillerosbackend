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
    public function login(Request $request){
        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)){
            return response()->json([
                'message' => 'Correo electrónico o contraseña incorrectos'
            ], 401);
        }
        $oClient = OClient::where('password_client', 1)->first();
        return $this->getTokenAndRefreshToken($oClient,request('email'), request('password'));
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
<<<<<<< HEAD
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
        return "Hola";

=======
        $response = Http::timeout(3)->post('http://localhost:3110/oauth/token', [
            "username" => $email,
            "password" => $password,
            "grant_type" => "password",
            "client_id" => $oClient->id,
            "client_secret" => $oClient->secret,
            "scope" => "",
        ]);
>>>>>>> eae13fb8307ec024793d470820f093c66f1a8839
        $result = json_decode((string) $response->getBody(), true);
        return response()->json([
            'authaccess'=>$result,
            'user' => Auth::user()
        ]);
    }

    public function me(){
        return response()->json([
            'user' => request('user')
        ],200);
    }
}
