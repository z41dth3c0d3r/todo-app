<?php

namespace App\Actions\ToDo;

use App\Models\Todo;
use Illuminate\Http\Request;

class CreateNewTodo
{
    public function handle(Request $request): Todo
    {
        return Todo::create([
            'todo' => $request->todo,
            'description' => $request->description,
            'expireAt' => $request->expireAt,
            'userId' => $request->user()->id
        ]);
    }
}
