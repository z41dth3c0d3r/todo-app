<?php

namespace App\DTO\ToDo;

class CreateTodoDTO
{
    public function __construct(
        public string $todo,
        public string $description,
        public string $expireAt,
        public int $userId
    ) {
    }
}
