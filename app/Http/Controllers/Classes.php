<?php

namespace App\Http\Controllers;

use App\Models\Classes as ModelsClasses;
use App\Models\Materials;
use Illuminate\Http\Request;

class Classes extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $data = ModelsClasses::with(['teachers', 'categories'])->filterByTeacher($request->teacher_id)->filterByCategory($request->category_id)->get();
        return response()->json([
            'status'    => true,
            'message'   => 'List Classes',
            'data'      => $data
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'teacher_id'        => 'required',
            'category_id'       => 'required',
            'title'             => 'required',
            'thumbnail_url'     => 'required',
            'description'       => 'required'
        ]);

        // Cek apakah title sudah ada
        $existing = ModelsClasses::where('title', $request->input('title'))->exists();


        if ($existing) {
            return response()->json([
                'message' => 'Content already exists'
            ], 208); // HTTP 208 Already Reported
        }

        $data = [
            'teacher_id'       => $request->input('teacher_id'),
            'category_id'       => $request->input('category_id'),
            'title'             => $request->input('title'),
            'thumbnail_url'     => $request->input('thumbnail_url'),
            'description'       => $request->input('description'),
        ];

        ModelsClasses::create($data);
        return response()->json([
            'message' => 'Data already added',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = ModelsClasses::where('class_id', $id)->with(['teachers', 'categories'])->get();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Classes not found'
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'Class is found',
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
