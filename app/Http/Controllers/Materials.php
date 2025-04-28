<?php

namespace App\Http\Controllers;

use App\Models\Materials as ModelsMaterials;
use Illuminate\Http\Request;

class Materials extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(String $id)
    {
        $data = ModelsMaterials::where('class_id', $id)->with(['classes.teachers', 'classes.categories'])->get();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Materials not found'
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'Material is found',
            'data'  => $data
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = ModelsMaterials::where('material_id', $id)->with(['classes.teachers', 'classes.categories'])->get();
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Materials not found'
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'Material is found',
            'data'  => $data
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
