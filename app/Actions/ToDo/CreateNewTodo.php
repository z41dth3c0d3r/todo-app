<?php

namespace App\Actions\ToDo;

use App\DTO\ToDo\CreateTodoDTO;
use App\Models\Todo;

class CreateNewTodo
{
    public function handle(CreateTodoDTO $todo): Todo
    {
        return Todo::create([
            'todo' => $todo->todo,
            'description' => $todo->description,
            'expireAt' => $todo->expireAt,
            'userId' => $todo->userId
        ]);
    }
}
