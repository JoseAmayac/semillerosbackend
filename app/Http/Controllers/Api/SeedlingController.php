<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Seedling;
use App\Http\Requests\SeedlingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeedlingController extends Controller
{
    public function __construct()
    {
        $this->middleware("checkauth")->only("store", "update", "delete");
    }

    /**
     * @OA\GET(
     *      path="/api/v1/seedlings",
     *      operationId="getSeedlings",
     *      tags={"Seedlings"},
     *      summary="Get seedlings information",
     *      description="Returns list of seedlings",
     *      @OA\Response(
     *         response=200,
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
        $seedlings = Seedling::all();
        return response()->json(['seedlings' => $seedlings], 200);
    }

    /**
     * @OA\POST(
     ** path="/api/v1/seedlings",
     *   tags={"Seedling"},
     *   summary="Store new seedling",
     *   operationId="storeSeedling",
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
     *      name="group_id",
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
    public function store(SeedlingRequest $request)
    {
        $seedling = Seedling::create($request->all());
        return response()->json(['seedling'=> $seedling], 201);
    }

    /**
     * @OA\GET(
     *      path="/api/v1/seedlings/{id}",
     *      operationId="getSeedlingById",
     *      tags={"Seedling"},
     *      summary="Get seedling information",
     *      description="Returns seedling data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Seedling id",
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
     * @param  \App\Models\Seedling  $seedling
     * @return \Illuminate\Http\Response
     */
    public function show(Seedling $seedling)
    {
        $seedling -> users ->load(['program' => function($query){
            $query->select(['name', 'id'])->get();
        }]);
        return response()->json(['seedling'=> $seedling], 200);
    }

    /**
     * @OA\PUT(
     ** path="/api/v1/seedlings/{id}",
     *   tags={"Seedling"},
     *   summary="Update existing seedling",
     *   operationId="updateSeedling",
     *   security={{"bearerAuth":{}}},
     *  @OA\Parameter(
     *          name="id",
     *          description="Seedling id",
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
     *  @OA\Parameter(
     *      name="group_id",
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
     * @param  \App\Models\Seedling  $seedling
     * @return \Illuminate\Http\Response
     */
    public function update(SeedlingRequest $request, Seedling $seedling)
    {
        $seedling->update($request->all());
        return response()->json(['seedling'=> $seedling], 201);
    }

    /**
     * @OA\DELETE(
     **  path="/api/v1/seedlings/{id}",
     *   tags={"Seedling"},
     *   summary="Delete an existing seedling",
     *   operationId="deleteSeedling",
     *   security={{"bearerAuth":{}}},
     *  @OA\Parameter(
     *          name="id",
     *          description="Seedling id",
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
     * @param  \App\Models\Seedling  $seedling
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seedling $seedling)
    {
        $seedling->delete();
        return response()->json(['message'=> 'Semillero eliminado correctamente'], 204);
    }
}
