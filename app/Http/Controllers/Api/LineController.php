<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LineRequest;
use App\Models\Line;
use Illuminate\Http\Request;

class LineController extends Controller
{

    public function __construct()
    {
        $this->middleware('checkauth')->only('store','update','delete');
    }


    /**
     * @OA\GET(
     *      path="/api/v1/lines",
     *      operationId="getLines",
     *      tags={"Lines"},
     *      summary="Get all lines information",
     *      description="Returns all lines information",
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
        $lines = Line::all();

        return response()->json([
            'lines' => $lines
        ],200);
    }

    /**
     * @OA\POST(
     **  path="/api/v1/lines",
     *   tags={"Lines"},
     *   summary="Store new investigation line",
     *   operationId="storeLine",
     *   description="Store new investigation lines in the database ",
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
     *      required=false,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="group_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *  ),
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
     *      description="El token de autenticación expiró | Token de autenticacion invalido",
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
    public function store(LineRequest $request)
    {
        $line = Line::create($request->all());

        return response()->json([
            'line' => $line
        ],201);
    }

    /**
     * @OA\GET(
     *      path="/api/v1/lines/{id}",
     *      operationId="getLineById",
     *      tags={"Lines"},
     *      summary="Get Specify line information",
     *      description="Returns one line information",
     *      @OA\Parameter(
     *          name="id",
     *          description="Line id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *       ),
     *      @OA\Response(
     *         response=200,
     *         description="Correct operation",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *      )
     *  )
    */
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Line  $line
     * @return \Illuminate\Http\Response
     */
    public function show(Line $line)
    {
        return response()->json([
            'line' => $line
        ],200);
    }

    /**
     * @OA\PUT(
     **  path="/api/v1/lines/{id}",
     *   tags={"Lines"},
     *   summary="Update a specify investigation lines",
     *   description="Returns updated investigation line data",
     *   operationId="updateLine",
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
     *      required=false,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="group_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *  ),
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
     *      description="El token de autenticación expiró | Token de autenticacion invalido",
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
     * @param  \App\Models\Line  $line
     * @return \Illuminate\Http\Response
     */
    public function update(LineRequest $request, Line $line)
    {
        $line->update($request->all());

        return response()->json([
            'line' => $line
        ],200);
    }

    /**
     * @OA\DELETE(
     *      path="/api/v1/lines/{id}",
     *      operationId="deleteLineById",
     *      tags={"Lines"},
     *      summary="Delete Specify line information",
     *      description="Return success message information",
     *      @OA\Parameter(
     *          name="id",
     *          description="Line id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *       ),
     *      @OA\Response(
     *         response=200,
     *         description="Correct operation",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *      ),
     *      @OA\Response(
     *         response="default",
     *         description="Operation error",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *      )
     *  )
    */
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Line  $line
     * @return \Illuminate\Http\Response
     */
    public function destroy(Line $line)
    {
        $line->delete();

        return response()->json([
            'message' => 'Linea de investigación eliminada correctamente'
        ],204);
    }
}
