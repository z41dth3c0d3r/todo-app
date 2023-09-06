<?php

namespace App\Actions\ToDo;

use App\Models\User;
use Illuminate\Support\Collection;

class GetAllTodo
{
    function handle($userId): Collection
    {
        $todos = User::with(['todos' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->find($userId);

        return $todos->todos;
    }
}
