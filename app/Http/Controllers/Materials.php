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
        $materials = ModelsMaterials::where('class_id', $id)->with('classes')->get();
        //hitung etag berdasarkan last_update
        $etag = hash('sha256', $materials->max('updated_at'));

        if (request()->header('If-None_Match') === $etag) {
            return response('', 304)->header('ETag', $etag);
        }

        if (!$materials) {
            return response()->json([
                'status' => false,
                'message' => 'data not found'
            ], 404);
        }



        //dd($materials);
        $result = $materials->map(function ($material) {
            return [
                'material_id' => $material->material_id,
                'class' => $material->classes->title,
                'title' => $material->title,
                'description' => $material->description,
                //'video_url' => $material->video_url,
                //'external_url' => $material->external_url,
                '_links' => [
                    [
                        'href' => 'classes/' . $material->classes->class_id,
                        'rel' => 'class',
                        'type' => 'GET'
                    ],

                ]
            ];
        });
        return response()->json([
            'status' => true,
            'message' => 'Material is found',
            'data'  => $result
        ], 200)->header('ETag', $etag)->header('Cache-Control', 'must-revalidate');
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
        $data = ModelsMaterials::where('material_id', $id)->with(['classes.teachers', 'classes.categories'])->first();
        //hitung etag berdasarkan last_update
        $etag = hash('sha256', $data['updated_at']);

        if (request()->header('If-None_Match') === $etag) {
            return response('', 304)->header('ETag', $etag);
        }

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Materials not found'
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'Material is found',
            'data'  => [
                'material_id' => $data->material_id,
                'class' => $data->classes->title,
                'title' => $data->title,
                'description' => $data->description,
                'video_url' => $data->video_url,
                'external_url' => $data->external_url,
                '_links' => [
                    [
                        'href' => 'classes/' . $data->classes->class_id,
                        'rel' => 'class',
                        'type' => 'GET'
                    ],
                    [
                        'href' => 'classes/' . $data->classes->class_id . '/materials',
                        'rel' => 'all_material',
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
