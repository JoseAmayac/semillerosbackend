<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct(){
        $this->middleware('checkauth')->except('index','show');
    }

    public function index(){
        $roles = Role::where('id','!=',4)->get();

        return response()->json([
            'roles' => $roles
        ]);
    }
}
