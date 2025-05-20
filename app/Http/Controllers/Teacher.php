<?php

namespace App\Http\Controllers;

use App\Models\Teachers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class Teacher extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Teachers::all();
        //hitung etag berdasarkan last_update
        $etag = hash('sha256', $data->max('updated_at'));

        if (request()->header('If-None_Match') === $etag) {
            return response('', 304)->header('ETag', $etag);
        }
        Cache::put($etag, $data, now()->addMinutes(300));
        $result = $data->map(function ($teacher) {
            return [
                'teacher_id' => $teacher->teacher_id,
                'name' => $teacher->name,
                'bio' => $teacher->bio,
                'photo_url' => $teacher->photo_url,
                '_links' => [
                    [
                        'href' => 'teachers/' . $teacher->teacher_id,
                        'rel' => 'teacher',
                        'type' => 'GET'
                    ]
                ]
            ];
        });
        return response()->json([
            'status' => true,
            'message' => 'List Teacher',
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
        $data = Teachers::find($id);
        //hitung etag berdasarkan last_update
        $etag = hash('sha256', $data['updated_at']);

        if (request()->header('If-None_Match') === $etag) {
            return response('', 304)->header('ETag', $etag);
        }
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Teacher not found'
            ], 404);
        }
        Cache::put($etag, $data, now()->addMinutes(300));
        return response()->json([
            'status' => true,
            'message' => 'Teacher is found',
            'data'  => [
                'teacher_id' => $data->teacher_id,
                'name' => $data->name,
                'bio' => $data->bio,
                'photo_url' => $data->photo_url,

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
