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
        $task = Task::with('user')->find($task->id);
        return response()->json([
            'message' => "Add task Successfully",
            'task' => $task
        ], 201);
    }

    public function index()
    {
        $tasks = Task::with('user')->get();

        return response()->json([
            "tasks" => $tasks
        ], 200);
    }

    public function update()
    {
        $task = Task::find(request('id'));
        if ($task) {
            $task->update([
                'task' => request('task'),
                'deadline' => request('deadline'),
            ]);
        }
        $updatedTask = Task::with('user')->where('id', $task->id)->first();
        return response()->json([
            "message" => "Update task successfully.",
            "task" => $updatedTask,
        ], 200);
    }

    public function delete()
    {
        $task = Task::find(request('id'));
        if ($task) {
            $task->delete();
            return response()->json(['message' => "Successfully deleted"], 200);
        }
    }
}
