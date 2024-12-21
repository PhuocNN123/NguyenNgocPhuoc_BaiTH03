<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::paginate(5);
        return view('tasks.index', compact('tasks'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'completed' => 'nullable|boolean',
        ]);

        $data = $request->all();
        $data['completed'] = $request->has('completed');

    Task::create($data);

    return redirect()->route('tasks.index')->with('success', 'Task created successfully.');


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::find($id);
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::find($id);
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        $data = $request->all();
    // Chuyển "completed" thành true nếu checkbox được chọn, ngược lại thành false
    $data['completed'] = $request->has('completed'); // Nếu có thì là true, không có thì là false

    // Tìm task theo ID và cập nhật
    $task = Task::findOrFail($id);
    $task->update($data);

    return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {   
        $task = Task::find($id);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');

    }
}