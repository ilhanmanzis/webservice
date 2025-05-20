<?php

namespace App\Http\Controllers;

use App\Models\Categories as ModelsCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class Categories extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ModelsCategories::all();

        //hitung etag berdasarkan last_update
        $etag = hash('sha256', $data->max('updated_at'));

        if (request()->header('If-None_Match') === $etag) {
            return response('', 304)->header('ETag', $etag);
        }

        Cache::put('categories_all', $data, now()->addMinutes(5));
        return response()->json([
            'status'    => true,
            'message'   => 'List Categories',
            'data'      => $data
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
        $data = ModelsCategories::where('category_id', $id)->first();
        //hitung etag berdasarkan last_update
        $etag = hash('sha256', $data['updated_at']);

        if (request()->header('If-None_Match') === $etag) {
            return response('', 304)->header('ETag', $etag);
        }
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data Categories',
            'data' => $data
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
