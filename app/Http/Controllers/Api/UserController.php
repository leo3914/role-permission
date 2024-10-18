<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

class UserController extends Controller
{
    public function register()
    {
        $validator = Validator::make(request()->all(), [
            'name' => ['required', 'min:4', 'max:40'],
            'email' => ['required', 'email', 'email:rfc,dns'],
            'phone' => ['required', 'min:9'],
            'password' => ['required', 'min:6', 'max:30'],
            'role_id' => ['nullable'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Unprocessable Content',
                'errors' => $validator->errors(),
            ], 422);
        }

        $exitedEmail = User::where('email', request('email'))->exists();

        if ($exitedEmail) {
            return response()->json([
                'message' => "Email already exists."
            ], 422);
        }

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
            'phone' => request('phone'),
            'role_id' => request('role_id') ?? 3,
        ]);

        // $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'message' => "User account successfully created.Please Login.",
        ], 201);
    }

    public function login()
    {
        $validator = Validator::make(request()->all(), [
            'email' => ['required', 'email', 'email:rfc,dns'],
            'password' => ['required', 'min:6', 'max:30'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Unprocessable Content',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', request('email'))->with('role.permissions')->first();

        if (!$user) {
            return response()->json([
                'message' => "Email doesn't exists."
            ], 422);
        }

        $isPasswordCorrect = Hash::check(request('password'), $user->password);

        if (!$isPasswordCorrect) {
            return response()->json([
                'message' => "Password Incorrect."
            ], 422);
        }

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'message' => "Login Success.",
            'token' => $token,
            'user' => $user,
            'role' => $user->role->role,
            'permissions' => $user->role->permissions,
        ], 200);
    }

    public function index()
    {
        try {
            $users = User::with('role', 'role.permissions')->get();
            return response()->json(['users' => $users], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to fetch users'], 500);
        }
    }

    public function update()
    {
        try {
            $user = User::find(request('id'));
            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $user->update([
                'name' => request('name'),
                'phone' => request('phone'),
                'role_id' => request('role_id'),
            ]);

            return response()->json([
                'message' => "Update user successfully."
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to update users',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function create()
    {
        $validator = Validator::make(request()->all(), [
            'name' => ['required', 'min:4', 'max:40'],
            'email' => ['required', 'email', 'email:rfc,dns'],
            'phone' => ['required', 'min:9'],
            'password' => ['required', 'min:6', 'max:30'],
            'role_id' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Unprocessable Content',
                'errors' => $validator->errors(),
            ], 422);
        }

        $exitedEmail = User::where('email', request('email'))->exists();

        if ($exitedEmail) {
            return response()->json([
                'message' => "Email already exists."
            ], 422);
        }

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
            'phone' => request('phone'),
            'role_id' => request('role_id'),
        ]);

        return response()->json([
            'message' => "User account successfully created.",
        ], 201);
    }

    public function showUser()
    {
        try {
            $user = User::find(request('id'));
            return response()->json(['user' => $user], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to fetch user'], 500);
        }
    }

    public function delete()
    {
        try {
            $user = User::find(request('id'));
            $user->delete();
            return response()->json(['message' => "User successfully deleted"], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to fetch user'], 500);
        }
    }

    public function getUser()
    {
        try {
            $user = User::with('role.permissions')->find(request('id'));
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
            return response()->json(['user' => $user], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to fetch users'], 500);
        }
    }
}
