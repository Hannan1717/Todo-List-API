<?php

namespace App\Http\Controllers\Api;

use App\Enums\TodoStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TodoResource::collection(Auth::user()->todos()->latest('id')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $todo = Todo::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'status' => TodoStatus::TODO->value,
        ]);
        return TodoResource::make($todo);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo)
    {
        $this->authorize('update', $todo);
        $this->validate($request, [
            'name' => 'required',
        ]);

        $todo->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return TodoResource::make($todo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        $this->authorize('delete', $todo);

        $todo->delete();
        return response()->json([
            'message' => 'Data deleted',
        ], 200);
    }
}
