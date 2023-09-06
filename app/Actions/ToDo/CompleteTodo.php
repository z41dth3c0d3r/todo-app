<?php

namespace App\Actions\ToDo;

use App\DTO\ToDo\CompleteDeleteTodoDTO;
use App\Models\Todo;
use App\Models\User;

class completeTodo
{
    function handle(CompleteDeleteTodoDTO $todoData): Todo
    {
        $todo = User::find($todoData->userId)->todos()->find($todoData->id);

        if ($todo->completedAt == null) {
            $todo->completedAt = now();
            $todo->update();
        }

        return $todo;
    }
}
