<?php

namespace App\DTO\ToDo;

class UpdateTodoDTO
{
    public function __construct(
        public int $id,
        public string $todo,
        public string $description,
        public string $expireAt,
        public int $userId
    ) {
    }
}
