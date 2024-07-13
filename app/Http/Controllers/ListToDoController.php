<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ListToDo;

// Atul Pratap Singh | WebReinvent Task | 13/07/2024

class ListToDoController extends Controller
{
    //
    public function index()
    {
        return view('index');
    }

    // Store a data into the database.

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:list_to_dos,name'
        ]);

        $task = ListToDo::create(['name' => $request->name]);

        return response()->json($task);
    }

    // Update a data into the database.

    public function update(ListToDo $task)
    {
        $task->completed = !$task->completed;
        $task->save();

        return response()->json($task);
    }

    // Delete a data from the database.

    public function destroy(ListToDo $task)
    {
        $task->delete();

        return response()->json(['success' => true]);
    }

    // Show all the data from the database.

    public function showAll()
    {
        $tasks = ListToDo::all();

        return response()->json($tasks);
    }
}
