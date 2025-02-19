<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Seedling;
use App\Models\User;
use App\Notifications\SetStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeedlingUserController extends Controller
{
    public function __construct() 
    {
        $this->middleware('checkauth');
        $this->middleware('role:Estudiante')->only('createSeedlingUser');
        $this->middleware('role:Semilleros general,Semilleros especifico')->except('createSeedlingUser');
    }

    public function createSeedlingUser(Request $request){
        $request -> validate([
            'user_id' => 'required|exists:users,id',
            'seedling_id' => 'required|exists:seedlings,id'
        ]);

        $seedling_user = DB::table('seedling_user')->where('user_id','=',$request -> get('user_id'))
        ->where('seedling_id', '=', $request -> get('seedling_id'))->first();
        if ($seedling_user) {
            return response()->json([
                'message' => 'Ya se encuentra inscrito en este semillero',
                'error' => 'registerExists'
            ], 422);
        }else{
            $seedling_user_created = DB::table('seedling_user')->insert(
                ['user_id' => $request -> get('user_id'), 'seedling_id' => $request -> get('seedling_id')]
            );
            return response()->json([
                'seedling_user' => $seedling_user_created,
                'message' => 'Se ha realizado su pre-inscripción al semillero'
            ], 201);
        }
    }

    public function setStatus(Request $request) {
        $request -> validate([
            'status' => 'required|integer',
            'seedling_user' => 'required|exists:seedling_user,id'
        ], [
            'seedling_user.exists' => 'Solicitud no encontrada'
        ]);
        $seedling_user = DB::table('seedling_user')->find($request->get('seedling_user'));
        $user = User::find($seedling_user->user_id);
        $seedling = Seedling::find($seedling_user->seedling_id);
        $seedling_user->status = $request->get('status');
        DB::table('seedling_user')
            ->where('id', $seedling_user->id)
            ->update(['status' => $request->status]);
        $user->notify(new SetStatusNotification(1,$seedling->name));
        return response() ->json([
            'message' => 'Usuario inscrito al semillero con éxito',
            'seedling_user' => $seedling_user
        ], 200);
    }

    public function deleteSeedlingUser(Request $request) {
        $request -> validate([
            'seedling_user' => 'required|exists:seedling_user,id'
        ]);
        $seedling_user = DB::table('seedling_user')->find($request->get('seedling_user'));
        $user = User::find($seedling_user->user_id);
        $seedling = Seedling::find($seedling_user->seedling_id);
        DB::table('seedling_user')->where('id', $seedling_user->id)->delete();
        $user->notify(new SetStatusNotification(0,$seedling->name));
        return response()->json([
            'message' => 'Solicitud rechazada con éxito',
            'eliminado' => $seedling_user
        ]);
    } 
}