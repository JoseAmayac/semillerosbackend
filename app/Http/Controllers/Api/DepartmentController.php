<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkauth')->except('index','show');
    }
    /**
     * @OA\GET(
     *      path="/api/v1/departments",
     *      operationId="getDepartments",
     *      tags={"Departments"},
     *      summary="Get departments information",
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
        $departments = Department::all();

        return response()->json([
            'departments' => $departments
        ], 201);
    }

        /**
     * @OA\POST(
     ** path="/api/v1/departments",
     *   tags={"Department"},
     *   summary="Store new department",
     *   operationId="storeDepartment",
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
    public function store(DepartmentRequest $request)
    {
        $department = Department::create($request->all());
        return response()->json([
            'message' => 'Departamento creado correctamente',
            'department' => $department
        ],201);
    }

    /**
     * @OA\GET(
     *      path="/api/v1/departments/{id}",
     *      operationId="getDepartmentById",
     *      tags={"Department"},
     *      summary="Get department information",
     *      description="Returns department data",
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
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        return response()->json([
            'department' => $department
        ],200);
    }

    /**
     * @OA\PUT(
     ** path="/api/v1/departments/{id}",
     *   tags={"Department"},
     *   summary="Update existing department",
     *   operationId="updateDepartment",
     *   security={{"bearerAuth":{}}},
     *  @OA\Parameter(
     *          name="id",
     *          description="Department id",
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
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentRequest $request, Department $department)
    {
        $department->update($request->all());

        return response()->json([
            'department' => $department
        ],200);
    }


    /**
     * @OA\DELETE(
     **  path="/api/v1/departments/{id}",
     *   tags={"Department"},
     *   summary="Delete an existing department",
     *   operationId="deleteDepartment",
     *   security={{"bearerAuth":{}}},
     *  @OA\Parameter(
     *          name="id",
     *          description="Department id",
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
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return response()->json([
            'message' => "Departamento eliminado correctamente"
        ],204);
    }
}
