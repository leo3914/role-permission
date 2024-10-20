<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function store()
    {
        $validator = Validator::make(request()->all(), [
            // "user_id" => ['required'],
            "role" => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Unprocessable Content.",
                'errors' => $validator->errors(),
            ], 422);
        }

        $role = Role::create([
            "role" => request('role'),
            // "user_id" => request('user_id'),
        ]);

        return response()->json([
            'message' => "Role create successfully.",
            "role" => $role,
        ], 200);
    }

    public function index()
    {
        $roles = Role::with('permissions')->get();
        return response()->json([
            "roles" => $roles,
        ], 200);
    }

    public function createRolePermission()
    {
        $validator = Validator::make(request()->all(), [
            'role' => 'required|string|unique:roles,name',
            'permissions' => 'required|array',
        ]);
        $role = Role::create([
            "role" => request('role')
        ]);

        $permissions = request('permissions');
        $role->permissions()->attach($permissions);
        $role->load('permissions');
        return response()->json([
            'message' => 'Role created successfully with assigned permissions.',
            'role' => $role
        ], 201);
    }

    public function getPermissions()
    {
        $permissions = Permission::all();
        return response()->json([
            'permissions' => $permissions,
            "message" => "Ok nar sar"
        ], 200);
    }
}
