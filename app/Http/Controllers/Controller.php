<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Todo;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function index()
    {
        $todos = Todo::all();
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
