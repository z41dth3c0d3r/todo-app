<?php

namespace App\DTO\ToDo;

class CompleteDeleteTodoDTO
{
    public function __construct(
        public string $id,
        public int $userId
    ) {
    }
}
