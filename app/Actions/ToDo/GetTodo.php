<?php

namespace App\Actions\ToDo;

use App\Models\Todo;
use Illuminate\Http\Request;

class GetTodo
{
    function handle($id): Todo
    {
        $todo = Todo::find($id);
        return $todo;
    }
}
