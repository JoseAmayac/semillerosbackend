<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Models\User;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController extends Controller
{
    public function create(Request $request){
        $request->validate([
            'email' => 'required|string|email',
        ]);
        
        $user = User::where('email', $request->email)->first();
        
        if (!$user){
            return response()->json([
                'message' => 'No pudimos encontrar un usuario con ese correo.'
            ],404);
        }

        $passwordReset = $this->insertPasswordReset($user);

        if ($user && $passwordReset)
            $user->notify(new PasswordResetRequest($passwordReset->token)
        );

        return response()->json([
            'message' => 'Enviamos un correo electrónico con el link para recuperar tu contraseña, revisa tu bandeja de entrada'
        ]);
    }

    public function insertPasswordReset($user){
        //Sacar a otro metodo
        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => \Illuminate\Support\Str::random(60)
            ]
        );

        return $passwordReset;
    }

    /**
     * Find token password reset
     *
     * @param  [string] $token
     * @return [string] message
     * @return [json] passwordReset object
     */
    public function find($token)
    {
        $passwordReset = PasswordReset::where('token', $token)->first();

        if (!$passwordReset)
            return response()->json([
                'message' => 'El token de restablecimiento de contraseña no es valido.'
            ], 404);
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(120)->isPast()) {
            $passwordReset->delete();
            return response()->json([
                'message' => 'El token de restablecimiento de contraseña ya expiró.'
            ], 403);
        }
        return response()->json($passwordReset);
    }

    /**
     * Reset password
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @param  [string] token
     * @return [string] message
     * @return [json] user object
     */
    public function reset(Request $request) //Generar request personalizado
    {
        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();

        if (!$passwordReset)
            return response()->json([
                'message' => 'El token de restablecimiento de contraseña no es valido.'
            ], 404);

        $user = User::where('email', $passwordReset->email)->first();

        if (!$user){
            return response()->json([
                'message' => 'No encontramos un usuario con ese correo electrónico.'
            ], 404);
        }
        $user->password = $request->get('password');
        $user->save();
        $passwordReset->delete();

        $user->notify(new PasswordResetSuccess($passwordReset));
        
        return response()->json([
            'message' => 'La contraseña se ha restablecido correctamente'
        ]);
    }
}
