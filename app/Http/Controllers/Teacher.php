<?php

namespace App\Http\Controllers;

use App\Models\Teachers;
use Illuminate\Http\Request;

class Teacher extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Teachers::all();
        return response()->json([
            'status' => true,
            'message' => 'List Teacher',
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
        $data = Teachers::find($id);
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Teacher not found'
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'Teacher is found',
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
