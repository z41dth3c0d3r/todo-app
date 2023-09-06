<?php

namespace App\Actions\ToDo;

use App\DTO\ToDo\CompleteDeleteTodoDTO;
use App\Models\Todo;
use App\Models\User;

class DeleteTodo
{
    function handle(CompleteDeleteTodoDTO $todoData): Todo
    {
        $todo = User::find($todoData->userId)->todos()->find($todoData->id);

        $todo->delete();

        return $todo;
    }
}
