<?php

namespace App\Actions\ToDo;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class GetAllTodo
{
    function handle(): Collection
    {
        $todos = User::with(['todos' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->find(Auth::id());

        return $todos->todos;
    }
}
