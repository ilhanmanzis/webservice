<?php

namespace App\Http\Controllers;

use App\Models\Feedbacks as ModelsFeedbacks;
use Illuminate\Http\Request;

class Feedbacks extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        $feedbacks = ModelsFeedbacks::where('class_id', $id)->with('classes', 'users')->get();
        //hitung etag berdasarkan last_update
        $etag = hash('sha256', $feedbacks->max('updated_at'));

        if (request()->header('If-None_Match') === $etag) {
            return response('', 304)->header('ETag', $etag);
        }

        if ($feedbacks->isEmpty()) {
            return response()->json([
                'took' => $_SERVER['REQUEST_TIME_FLOAT'],
                'code' => 404,
                'message' => 'data not found'
            ], 404);
        }

        $result = $feedbacks->map(function ($feedback) {
            return [
                'feedback_id' => $feedback->feedback_id,
                'user' => $feedback->users->name,
                'class' => $feedback->classes->title,
                'rating' => $feedback->rating,
                'comment' => $feedback->comment,
                '_links' => [
                    [
                        'href' => 'classes/' . $feedback->classes->class_id,
                        'rel' => 'classes',
                        'type' => 'GET'
                    ],
                    [
                        'href' => 'users/' . $feedback->users->id,
                        'rel' => 'classes',
                        'type' => 'GET'
                    ],

                ]
            ];
        });

        return response()->json([
            'took' => $_SERVER['REQUEST_TIME_FLOAT'],
            'code' => 200,
            'message' => 'all feedback class' . $feedbacks[0]->classes->name,
            'data' => $result
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
        $request->validate([
            'user_id' => 'required',
            'class_id' => 'required',
            'rating' => 'required',
            'comment' => 'required',
        ]);

        $existing = ModelsFeedbacks::where('comment', $request->input('comment'))->where('user_id', $request->input('user_id'))->where('class_id', $request->input('class_id'))->exists();

        if (!$existing) {
            $data = [
                'user_id'   => $request->input('user_id'),
                'class_id'   => $request->input('class_id'),
                'rating'   => $request->input('rating'),
                'comment'   => $request->input('comment'),
            ];

            $insert = ModelsFeedbacks::create($data);
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
    public function show(string $id)
    {
        $feedback = ModelsFeedbacks::with('classes', 'users')->find($id);
        //hitung etag berdasarkan last_update
        $etag = hash('sha256', $feedback->max('updated_at'));

        if (request()->header('If-None_Match') === $etag) {
            return response('', 304)->header('ETag', $etag);
        }

        if ($feedback->isEmpty()) {
            return response()->json([
                'took' => $_SERVER['REQUEST_TIME_FLOAT'],
                'code' => 404,
                'message' => 'data not found'
            ], 404);
        }

        return response()->json([
            'took' => $_SERVER['REQUEST_TIME_FLOAT'],
            'code' => 200,
            'message' => 'feedback class' . $feedback->classes->name,
            'data' => [
                'feedback_id' => $feedback->feedback_id,
                'user' => $feedback->users->name,
                'class' => $feedback->classes->title,
                'rating' => $feedback->rating,
                'comment' => $feedback->comment,
                '_links' => [
                    [
                        'href' => 'classes/' . $feedback->classes->class_id,
                        'rel' => 'classes',
                        'type' => 'GET'
                    ],
                    [
                        'href' => 'users/' . $feedback->users->id,
                        'rel' => 'classes',
                        'type' => 'GET'
                    ],
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
