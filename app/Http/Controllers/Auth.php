<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Auth extends Controller
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
            'name'  => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);
        $existing = User::where('email', $request->input('email'))->exists();
        if (!$existing) {
            $data = [
                'name'  => $request->input('name'),
                'email'  => $request->input('email'),
                'password'  => Hash::make($request->input('password'))
            ];
            $insert = User::create($data);
            if ($insert) {
                return response()->json([
                    'took'  => $_SERVER['REQUEST_TIME_FLOAT'],
                    'code'  => 201,
                    'message' => 'Data Already Added'
                ], 201);
            } else {
                return response()->json([
                    'took'  => $_SERVER['REQUEST_TIME_FLOAT'],
                    'code'  => 502,
                    'message' => 'Data Failed'
                ], 502);
            }
        } else {
            return response()->json([
                'took'  => $_SERVER['REQUEST_TIME_FLOAT'],
                'code'  => 208,
                'status' => 'Already content'
            ], 208);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
