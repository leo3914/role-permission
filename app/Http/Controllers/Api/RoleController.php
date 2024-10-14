<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function store()
    {
        $validator = Validator::make(request()->all(), [
            "user_id" => ['required'],
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
            "user_id" => request('user_id'),
        ]);

        return response()->json([
            'message' => "Role create successfully.",
            "role" => $role,
        ], 200);
    }
}
