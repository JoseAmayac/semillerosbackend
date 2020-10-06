<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Seedling;
use App\Http\Requests\SeedlingRequest;
use Illuminate\Http\Request;

class SeedlingController extends Controller
{
    public function __construct()
    {
        $this->middleware("checkauth")->only("store", "update", "delete");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seedlings = Seedling::all();
        return response()->json(['seedlings', $seedlings], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SeedlingRequest $request)
    {
        $seedling = Seedling::create($request->all());
        return response()->json(['seedling', $seedling], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Seedling  $seedling
     * @return \Illuminate\Http\Response
     */
    public function show(Seedling $seedling)
    {
        return response()->json(['seedling', $seedling], 200);
    }

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
        return response()->json(['seedling', $seedling], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seedling  $seedling
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seedling $seedling)
    {
        $seedling->delete();
        return response()->json(['message', 'Semillero eliminado correctamente'], 204);
    }
}
