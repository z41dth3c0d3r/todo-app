<?php

namespace App\Actions\ToDo;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;

class completeTodo
{
    function handle(Request $request): Todo
    {
        $todo = User::find($request->user()->id)->todos()->find($request->id);

        if ($todo->completedAt == null) {
            $todo->completedAt = now();
            $todo->update();
        }

        return $todo;
    }
}
