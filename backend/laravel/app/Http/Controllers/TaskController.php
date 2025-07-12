<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('user')->get();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'deadline' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $task = Task::create($request->all());
        
        // Send email notification
        $user = User::find($request->user_id);
        Mail::raw("You have been assigned a new task: {$task->title}", function($message) use ($user) {
            $message->to($user->email)
                    ->subject('New Task Assignment');
        });

        return response()->json($task->load('user'), 201);
    }

    public function show(Task $task)
    {
        return response()->json($task->load('user'));
    }

    public function update(Request $request, Task $task)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'user_id' => 'sometimes|exists:users,id',
            'status' => 'sometimes|in:pending,in_progress,completed',
            'deadline' => 'sometimes|date'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $task->update($request->all());
        return response()->json($task->load('user'));
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }

    public function userTasks()
    {
        $tasks = auth()->user()->tasks;
        return response()->json($tasks);
    }

    public function updateStatus(Request $request, Task $task)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,in_progress,completed'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Only allow users to update their own tasks
        if ($task->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $task->update(['status' => $request->status]);
        return response()->json($task);
    }
}