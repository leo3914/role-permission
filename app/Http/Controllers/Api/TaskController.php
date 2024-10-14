<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'task' => ['required'],
            'deadline' => ['required'],
            'user_id' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors(),
            ], 422);
        }
        $task = Task::create([
            'task' => request('task'),
            'deadline' => request('deadline'),
            'user_id' => request('user_id')
        ]);

        return response()->json([
            'message' => "Add task Successfully",
        ], 201);
    }

    public function index()
    {
       $users = User::with('tasks')->with('role')->get();

       return response()->json([
        "users" => $users
       ]);
    }
}
