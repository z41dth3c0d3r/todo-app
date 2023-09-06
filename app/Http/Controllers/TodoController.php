<?php

namespace App\Http\Controllers;

use App\Actions\ToDo\completeTodo;
use App\Actions\ToDo\CreateNewTodo;
use App\Actions\ToDo\DeleteTodo;
use App\Actions\ToDo\GetAllTodo;
use App\Actions\ToDo\GetTodo;
use App\Actions\ToDo\UpdateTodo;
use App\DTO\ToDo\CompleteDeleteTodoDTO;
use App\DTO\ToDo\CreateTodoDTO;
use App\DTO\ToDo\UpdateTodoDTO;
use App\Http\Requests\TodoRequests\CompleteTodoRequest;
use App\Http\Requests\TodoRequests\CreateNewTodoRequest;
use App\Http\Requests\TodoRequests\DeleteTodoRequest;
use App\Http\Requests\TodoRequests\UpdateTodoRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class TodoController extends Controller
{
    public function store(CreateNewTodoRequest $request, CreateNewTodo $createNewTodo): RedirectResponse
    {
        // creating DTO from request
        $todo = new CreateTodoDTO($request->todo, $request->description, $request->expireAt, $request->user()->id);

        // passing newly created DTO to createNewTodo action
        $createNewTodo->handle($todo);

        return back()->with(['status' => 'todo-created']);
    }

    public function show(GetAllTodo $getAllTodos): View
    {
        $todos = $getAllTodos->handle(Auth::user()->id);

        $status = Session::get('status');

        return view("dashboard", ['todos' => $todos, 'status' => $status]);
    }

    function completeTodo(CompleteTodoRequest $request, completeTodo $completeTodo): RedirectResponse
    {
        $todoData = new CompleteDeleteTodoDTO($request->id, $request->user()->id);
        $completeTodo->handle($todoData);

        return Redirect::route('dashboard')->with('status', 'todo-completed');
    }

    function deleteTodo(DeleteTodoRequest $request, DeleteTodo $deleteTodo): RedirectResponse
    {
        $todoData = new CompleteDeleteTodoDTO($request->id, $request->user()->id);
        $deleteTodo->handle($todoData);
        return Redirect::route('dashboard')->with('status', 'todo-deleted');
    }

    function edit($id, GetTodo $getTodo)
    {
        $todo = $getTodo->handle($id);
        return view("todo.edit", ['todo' => $todo]);
    }

    function update(UpdateTodoRequest $request, UpdateTodo $updateTodo): RedirectResponse
    {
        $todoData = new UpdateTodoDTO($request->id, $request->todo, $request->description, $request->expireAt, $request->user()->id);
        $updateTodo->handle($todoData);
        return back()->with(['status' => 'todo-updated']);
    }
}
