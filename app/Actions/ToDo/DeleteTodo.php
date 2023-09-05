<?php

namespace App\Actions\ToDo;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;

class DeleteTodo
{
    function handle(Request $request): Todo
    {
        $todo = User::find($request->user()->id)->todos()->find($request->id);

        $todo->delete();

        return $todo;
    }
}
