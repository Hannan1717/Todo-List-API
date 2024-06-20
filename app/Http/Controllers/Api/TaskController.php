<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Policies\TaskPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function index()
    {
        // Mengambil semua tasks dari user yang terautentikasi, diurutkan berdasarkan id terbaru
        $tasks = Auth::user()->tasks()->latest('id')->get();

        // Mengembalikan koleksi tasks sebagai resource collection
        return TaskResource::collection($tasks);
    }

    public function employeeTasks()
    {
        return TaskResource::collection(Auth::user()->assignedTasks()->latest('id')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'assigned_user_id' => 'required|exists:users,id',
        ]);

        $task = Task::create([
            'name' => $request->name,
            'user_id' => Auth::id(),
            'assigned_user_id' => $request->assigned_user_id,
            'status' => 'Todo',
        ]);

        return TaskResource::make($task);
    }

    public function updateByAdmin(Request $request, Task $task)
    {
        Log::info('Current User: ' . Auth::id());
        Log::info('Task User ID: ' . $task->user_id);

        $this->authorize('updateByAdm', $task);

        // Validasi data yang diterima dari request
        $this->validate($request, [
            'name' => 'required',
            'assigned_user_id' => 'required',
        ]);

        // Lakukan pembaruan task
        $task->update([
            'name' => $request->name,
            'assigned_user_id' => $request->assigned_user_id,
        ]);

        // Mengembalikan response dalam bentuk TaskResource
        return TaskResource::make($task);
    }



    public function updateByEmp(Request $request, Task $task)
    {
        $this->authorize('updateByEmp', $task);

        // Validasi data yang diterima dari request
        $this->validate($request, [
            'status' => 'required|in:Todo,On progress,Done',
        ]);

        // Lakukan pembaruan task
        $task->update([
            'status' => $request->status,
        ]);

        // Mengembalikan response dalam bentuk TaskResource
        return TaskResource::make($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();
        return response()->json([
            'message' => 'Data deleted',
        ], 200);
    }
}
