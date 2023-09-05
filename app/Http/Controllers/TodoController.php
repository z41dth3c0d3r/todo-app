<?php

namespace App\Http\Controllers;

use App\Actions\ToDo\completeTodo;
use App\Actions\ToDo\CreateNewTodo;
use App\Actions\ToDo\DeleteTodo;
use App\Actions\ToDo\GetAllTodo;
use App\Actions\ToDo\GetTodo;
use App\Actions\ToDo\UpdateTodo;
use App\Http\Requests\TodoRequests\CompleteTodoRequest;
use App\Http\Requests\TodoRequests\CreateNewTodoRequest;
use App\Http\Requests\TodoRequests\DeleteTodoRequest;
use App\Http\Requests\TodoRequests\UpdateTodoRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class TodoController extends Controller
{
    public function store(CreateNewTodoRequest $request, CreateNewTodo $createNewTodo): RedirectResponse
    {
        $createNewTodo->handle($request);
        return back()->with(['status' => 'todo-created']);
    }

    public function show(GetAllTodo $getAllTodos): View
    {
        $todos = $getAllTodos->handle();

        $status = Session::get('status');

        return view("dashboard", ['todos' => $todos, 'status' => $status]);
    }

    function completeTodo(CompleteTodoRequest $request, completeTodo $completeTodo): RedirectResponse
    {
        $completeTodo->handle($request);

        return Redirect::route('dashboard')->with('status', 'todo-completed');
    }

    function deleteTodo(DeleteTodoRequest $request, DeleteTodo $deleteTodo): RedirectResponse
    {
        $deleteTodo->handle($request);
        return Redirect::route('dashboard')->with('status', 'todo-deleted');
    }

    function edit($id, GetTodo $getTodo)
    {
        $todo = $getTodo->handle($id);
        return view("todo.edit", ['todo' => $todo]);
    }

    function update(UpdateTodoRequest $request, UpdateTodo $updateTodo): RedirectResponse
    {
        $updateTodo->handle($request);
        return back()->with(['status' => 'todo-updated']);
    }
}
