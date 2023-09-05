<?php

namespace App\Actions\ToDo;

use App\Models\Todo;
use Illuminate\Http\Request;

class UpdateTodo
{
    public function handle(Request $request): Bool
    {
        $todo = Todo::find($request->id);
        $todo->todo = $request->todo;
        $todo->description = $request->description;
        $todo->expireAt = $request->expireAt;

        return $todo->update();
    }
}
