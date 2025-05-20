<?php

namespace App\Http\Controllers;

use App\Models\Classes as ModelsClasses;
use App\Models\Materials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class Classes extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $classes = ModelsClasses::with(['teachers', 'categories'])->filterByTeacher($request->teacher_id)->filterByCategory($request->category_id)->get();
        //hitung etag berdasarkan last_update
        $etag = hash('sha256', $classes->max('updated_at'));

        if (request()->header('If-None_Match') === $etag) {
            return response('', 304)->header('ETag', $etag);
        }
        Cache::put($etag, $classes, now()->addMinutes(300));
        $result = $classes->map(function ($class) {
            return [
                'class_id' => $class->class_id,
                'title' => $class->title,
                'thumbnail_url' => $class->thumbnail_url,
                'teacher' => $class->teachers->name,
                'category' => $class->categories->name,
                '_links' => [

                    [
                        'href' => 'teachers/' . $class->teachers->teacher_id,
                        'rel' => 'teachers',
                        'type' => 'GET'
                    ],
                    [
                        'href' => 'categories/' . $class->categories->category_id,
                        'rel' => 'categories',
                        'type' => 'GET'
                    ]

                ]
            ];
        });
        return response()->json([
            'status'    => true,
            'message'   => 'List Classes',
            'data'      => $result
        ], 200)->header('ETag', $etag)->header('Cache-Control', 'must-revalidate');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = ModelsClasses::where('class_id', $id)->with(['teachers', 'categories'])->first();
        //hitung etag berdasarkan last_update
        $etag = hash('sha256', $data['updated_at']);

        if (request()->header('If-None_Match') === $etag) {
            return response('', 304)->header('ETag', $etag);
        }
        Cache::put($etag, $data, now()->addMinutes(300));

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Classes not found'
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'Class is found',
            'data'  => [
                'class_id' => $data->class_id,
                'title' => $data->title,
                'thumbnail_url' => $data->thumbnail_url,
                'teacher' => $data->teachers->name,
                'category' => $data->categories->name,
                '_links' => [
                    [
                        'href' => 'teachers/' . $data->teachers->teacher_id,
                        'rel' => 'teachers',
                        'type' => 'GET'
                    ],
                    [
                        'href' => 'categories/' . $data->categories->category_id,
                        'rel' => 'categories',
                        'type' => 'GET'
                    ]
                ]
            ]
        ], 200)->header('ETag', $etag)->header('Cache-Control', 'must-revalidate');
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
