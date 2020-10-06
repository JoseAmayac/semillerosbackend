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
