<?php

namespace App\Actions\ToDo;

use App\DTO\ToDo\UpdateTodoDTO;
use App\Models\Todo;

class UpdateTodo
{
    public function handle(UpdateTodoDTO $todoData): Bool
    {
        $todo = Todo::find($todoData->id);
        $todo->todo = $todoData->todo;
        $todo->description = $todoData->description;
        $todo->expireAt = $todoData->expireAt;

        return $todo->update();
    }
}
