<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class Users extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $data = User::find($id);

        //hitung etag berdasarkan last_update
        $etag = hash('sha256', $data['updated_at']);

        if (request()->header('If-None_Match') === $etag) {
            return response('', 304)->header('ETag', $etag);
        }

        return response()->json([
            'took' => $_SERVER['REQUEST_TIME_FLOAT'],
            'code' => 200,
            'data' => [
                'name' => $data['name'],
                'email' => $data['email']
            ]
        ], 200)->header('ETag', $etag)->header('Cache-Control', 'must-revalidate');
    }

    public function profile()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid token'], 400);
        }

        //hitung etag berdasarkan last_update
        $etag = hash('sha256', $user['updated_at']);

        if (request()->header('If-None_Match') === $etag) {
            return response('', 304)->header('ETag', $etag);
        }

        return response()->json([
            'took' => $_SERVER['REQUEST_TIME_FLOAT'],
            'code' => 200,
            'data' => $user
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
    public function update(Request $request, string $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
