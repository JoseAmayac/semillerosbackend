<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\SignUpRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('checkauth')->except(['show', 'getTeachers','updatePassword']);
    }

    /**
     * @OA\GET(
     *      path="/api/v1/users",
     *      operationId="getUsers",
     *      tags={"Users"},
     *      summary="Get users information",
     *      description="Returns list of users",
     *      @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *      )
     *  )
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('roles')->get();

        return response()->json([
            'users' => $users
        ],200);
    }

    /**
     * @OA\Post(
     ** path="/api/v1/users",
     *   tags={"User"},
     *   summary="Store new user",
     *   operationId="storeUser",
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $user = User::create($data);

        $role = Role::findById((int)$request->get('role_id'),'web');

        $user->assignRole($role);
        $user->save();

        return response()->json([
            'user' => $user,
            'message' => 'Usuario agregado correctamente'
        ],201);
    }

    /**
     * @OA\GET(
     *      path="/api/v1/users/{id}",
     *      operationId="getUserById",
     *      tags={"User"},
     *      summary="Get user information",
     *      description="Returns user data",
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *      )
     *  )
     */
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user -> program;
        $user -> department;
        return response()->json([
            'user' => $user
        ],200);
    }

    /**
     * @OA\PUT(
     ** path="/api/v1/users/{id}",
     *   tags={"User"},
     *   summary="Update existing user",
     *   operationId="updateUser",
     *  @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *   ),
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $userUpdated = tap($user)->update($request->all());

        return response()->json([
            'user' => $userUpdated,
            'message' => 'Usuario Actualizado con éxito'
        ],200);
    }

    /**
     * @OA\DELETE(
     **  path="/api/v1/users/{id}",
     *   tags={"User"},
     *   summary="Delete an existing user",
     *   operationId="deleteUser",
     *   security={{"bearerAuth":{}}},
     *  @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *   ),
     *  @OA\Response(
     *      response=204,
     *       description="No content",
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'message' => 'Usuario eliminado correctamente'
        ],200);
    }

    public function getTeachers()
    {
        $teachers = User::whereHas('roles',function($query){
            $query->where('id','=',2)->orWhere('id','=',3);
        })->with('department')->get();

        return response()->json([
            'teachers' => $teachers
        ],200);
    }

    public function updatePassword(PasswordRequest $request) {
        $user = User::find(Auth::id());
        $password = bcrypt($request->new_password);
        $current_password = $request->password;
        if (!Hash::check($current_password, $user->password)) {
            return response()->json([
                'message' => 'La contraseña actual no es correcta'
            ], 401);
        }
        $user ->password = $password;
        $user->save();
        return response()->json([
            'user' => $user,
            'message' => 'Contraseña Actualizada con éxito'
        ],200);
    }
}