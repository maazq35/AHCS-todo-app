<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Todo;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::all();
        config('ahcsTodo.laravel');

        return view('welcome', compact('todos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'todo' => 'required',
            ]);

        $todo = new Todo();
        $todo->todo = $request->todo;
        $todo->save();
        return response($todo, 200);
    }

    public function update(Todo $todo, Request $request)
    {
        $request->validate([
            'todo' => 'required',
            ]);

        $todo->todo = $request->todo;
        $todo->save();
        return response($todo, 200);
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return response($todo, 201);
    }
}