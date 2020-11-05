<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProgramRequest;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function __construct()
    {
        $this->middleware("checkauth")->only("store", "update", "delete");
    }


    /**
     * @OA\GET(
     *      path="/api/v1/programs",
     *      operationId="getPrograms",
     *      tags={"Programs"},
     *      summary="Get all academic programs information",
     *      description="Returns all academic programs information",
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
        $programs = Program::all();
        return response()->json(['programs' => $programs], 200);
    }

    /**
     * @OA\POST(
     **  path="/api/v1/programs",
     *   tags={"Programs"},
     *   summary="Store new academic program",
     *   operationId="storeProgram",
     *   description="Store new academic program in the database ",
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
     *      name="department_id",
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
     *      description="Unprocessable Entity",
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
    public function store(ProgramRequest $request)
    {
        $program = Program::create($request->all());

        return response()->json([
            'message' => 'Programa académico creado correctamente',
            'program' => $program
        ],201);
    }

    /**
     * @OA\GET(
     *      path="/api/v1/programs/{id}",
     *      operationId="getProgramById",
     *      tags={"Programs"},
     *      summary="Get Specify academic program information",
     *      description="Returns one academic program information",
     *      @OA\Parameter(
     *          name="id",
     *          description="Academic program id",
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
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function show(Program $program)
    {
        return response()->json(['program'=> $program], 200);
    }

    /**
     * @OA\PUT(
     **  path="/api/v1/programs/{id}",
     *   tags={"Programs"},
     *   summary="Update a specify academic program",
     *   description="Returns updated academic program data",
     *   operationId="updateProgram",
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
     *      name="department_id",
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
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function update(ProgramRequest $request, Program $program)
    {
        $program->update($request->all());
        return response()->json(['program'=> $program], 201);
    }

    /**
     * @OA\DELETE(
     *      path="/api/v1/programs/{id}",
     *      operationId="deleteProgramsById",
     *      tags={"Programs"},
     *      summary="Delete Specify academic program information",
     *      description="Return success message information",
     *      @OA\Parameter(
     *          name="id",
     *          description="Academic program id",
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
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function destroy(Program $program)
    {
        $program->delete();
        return response()->json(['message'=> 'Programa eliminado correctamente'], 204);
    }
}
