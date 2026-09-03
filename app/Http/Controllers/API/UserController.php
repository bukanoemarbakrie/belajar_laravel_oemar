<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = User::all();
            return response()->json([
                'status' => true,
                'message' => 'Fetch data success',
                'data' => $users,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Internal server error',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8'
            ]);

            if ($validation->fails()) {
                return response()->json([
                    'message' => 'Validation Fail',
                    'errors' => $validation->errors()
                ], 422);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password), // Hash password
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Create user success',
                'data' => $user,
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Internal server error',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json([
                'status' => true,
                'message' => 'Fetch user detail success',
                'data' => $user,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
                'errors' => $th->getMessage()
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json([
                'status' => true,
                'message' => 'Fetch edit user success',
                'data' => $user,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Internal error server',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validation = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'nullable|min:8'
            ]);

            if ($validation->fails()) {
                return response()->json([
                    'message' => 'Validation Fail',
                    'errors' => $validation->errors()
                ], 422);
            }

            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Update user success',
                'data' => $user,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Internal server error',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json([
                'status' => true,
                'message' => 'Delete user success',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Internal error server',
                'errors' => $th->getMessage(),
            ], 500);
        }
    }
}
