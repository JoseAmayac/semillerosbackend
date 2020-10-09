<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Requests\GroupRequest;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware("checkauth")->only("store", "update", "delete");
    }

    /**
     * @OA\GET(
     *      path="/api/v1/groups",
     *      operationId="getGroups",
     *      tags={"Groups"},
     *      summary="Get groups information",
     *      description="Returns list of departments",
     *      @OA\Response(
     *         response=201,
     *         description="Successful operation",
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
        $groups = Group::all();
        return response()->json(['groups'=>$groups], 200);
    }
    /**
     * @OA\POST(
     ** path="/api/v1/groups",
     *   tags={"Group"},
     *   summary="Store new group",
     *   operationId="storeGroup",
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="description",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="department_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Response(
     *      response=201,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *  @OA\Response(
     *      response=422,
     *       description="Unprocessable Entity",
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupRequest $request)
    {
        $group = Group::create($request->all());
        return response()->json(['group'=>$group], 201);
    }

    /**
     * @OA\GET(
     *      path="/api/v1/groups/{id}",
     *      operationId="getGroupById",
     *      tags={"Group"},
     *      summary="Get group information",
     *      description="Returns group data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Department id",
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
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        return response()->json(['group', $group], 200);
    }


    /**
     * @OA\PUT(
     ** path="/api/v1/groups/{id}",
     *   tags={"Group"},
     *   summary="Update existing group",
     *   operationId="updateGroup",
     *   security={{"bearerAuth":{}}},
     *  @OA\Parameter(
     *          name="id",
     *          description="Group id",
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
     *      name="description",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *  @OA\Response(
     *      response=422,
     *       description="Unprocessable Entity",
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(GroupRequest $request, Group $group)
    {
        $group->update($request->all());
        return response()->json(['group'=>$group], 201);
    }

    /**
     * @OA\DELETE(
     **  path="/api/v1/groups/{id}",
     *   tags={"Group"},
     *   summary="Delete an existing group",
     *   operationId="deleteGroup",
     *   security={{"bearerAuth":{}}},
     *  @OA\Parameter(
     *          name="id",
     *          description="Group id",
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
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();
        return response()->json(['message', 'Grupo eliminado correctamente'], 204);
    }
}
