<?php

namespace App\Http\Controllers;

use App\Models\Enrollments as ModelsEnrollments;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class Enrollments extends Controller
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
        $request->validate([
            'user_id' => 'required',
            'class_id' => 'required',
        ]);

        $existing = ModelsEnrollments::where('user_id', $request->input('user_id'))->where('class_id', $request->input('class_id'))->exists();
        if (!$existing) {
            $data = [
                'user_id'   => $request->input('user_id'),
                'class_id'   => $request->input('class_id')
            ];
            $insert = ModelsEnrollments::create($data);
            if ($insert) {
                return response()->json([
                    'took'      => $_SERVER['REQUEST_TIME_FLOAT'],
                    'code'      => 201,
                    'message'   => 'Data Already Added'
                ], 201);
            } else {
                return response()->json([
                    'took'      => $_SERVER['REQUEST_TIME_FLOAT'],
                    'code'      => 502,
                    'message'   => 'Data Failed'
                ], 502);
            }
        } else {
            return response()->json([
                'took'      => $_SERVER['REQUEST_TIME_FLOAT'],
                'code'      => 208,
                'message'   => 'Already Content'
            ], 208);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid token'], 400);
        }
        $userId = $user['id']; // Mengambil dari query string ?user_id=

        $user = User::with('classes.teachers', 'classes.categories')->find($userId);

        //hitung etag berdasarkan last_update
        $etag = hash('sha256', $user['updated_at']);

        if (request()->header('If-None_Match') === $etag) {
            return response('', 304)->header('ETag', $etag);
        }

        Cache::put($etag, $user, now()->addMinutes(300));
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
                'data' => null
            ], 404);
        }

        $result = $user->classes->map(function ($class) use ($user) {
            return [
                'class_id' => $class->class_id,
                'title' => $class->title,
                'thumbnail_url' => $class->thumbnail_url,
                'description' => $class->description,
                'teacher' => $class->teachers->name ?? null,
                'category' => $class->categories->name ?? null,
                '_links' => [
                    [
                        'href' => 'classes/' . $class->class_id,
                        'rel' => 'classes',
                        'type' => 'GET'
                    ],
                    [
                        'href' => 'users/' . $user->id,
                        'rel' => 'classes',
                        'type' => 'GET'
                    ]
                ]
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'My classes',
            'data' => $result
        ])->header('ETag', $etag)->header('Cache-Control', 'must-revalidate');
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
