<?php

namespace Tests\Feature;

use App\Actions\ToDo\completeTodo;
use App\Actions\ToDo\CreateNewTodo;
use App\Actions\ToDo\DeleteTodo;
use App\Actions\ToDo\GetAllTodo;
use App\Actions\ToDo\GetTodo;
use App\Actions\ToDo\UpdateTodo;
use App\DTO\ToDo\CompleteDeleteTodoDTO;
use App\DTO\ToDo\CreateTodoDTO;
use App\DTO\ToDo\UpdateTodoDTO;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class TodoActionsTest extends TestCase
{
    use RefreshDatabase;
    public function test_create_new_todo_action(): void
    {
        $user = User::factory()->create();
        $todoData = new CreateTodoDTO('test todo', 'test description', now(), $user->id);
        $createNewTodo = new CreateNewTodo();

        $todo = $createNewTodo->handle($todoData);

        $this->assertDatabaseHas('todos', [
            'todo' => $todo->todo,
            'description' => $todo->description,
            'expireAt' => $todo->expireAt,
            'userId' => $todo->userId,
        ]);
    }

    public function test_complete_todo_actions(): void
    {
        $user = User::factory()->create();
        $newTodo = new CreateTodoDTO('test todo', 'test description', now(), $user->id);

        $createNewTodoAction = new CreateNewTodo();

        $todo = $createNewTodoAction->handle($newTodo);

        $this->assertDatabaseHas('todos', [
            'todo' => $todo->todo,
            'description' => $todo->description,
            'expireAt' => $todo->expireAt,
            'userId' => $todo->userId,
        ]);

        $completeTodoAction = new completeTodo();

        $completingTodoData = new CompleteDeleteTodoDTO($todo->id, $todo->userId);

        $completedTodo = $completeTodoAction->handle($completingTodoData);

        $this->assertNotNull($completedTodo->completedAt);
    }

    public function test_delete_todo_actions(): void
    {
        $user = User::factory()->create();
        $newTodo = new CreateTodoDTO('test todo', 'test description', now(), $user->id);

        $createNewTodoAction = new CreateNewTodo();

        $todo = $createNewTodoAction->handle($newTodo);

        $this->assertDatabaseHas('todos', [
            'todo' => $todo->todo,
            'description' => $todo->description,
            'expireAt' => $todo->expireAt,
            'userId' => $todo->userId,
        ]);

        $deleteTodoAction = new DeleteTodo();

        $deletingTodoData = new CompleteDeleteTodoDTO($todo->id, $todo->userId);

        $deletedTodo = $deleteTodoAction->handle($deletingTodoData);

        $this->assertDatabaseMissing('todos', [
            'todo' => $todo->todo,
            'description' => $todo->description,
            'expireAt' => $todo->expireAt,
            'userId' => $todo->userId,
        ]);
    }

    function test_update_todo_action(): void
    {
        $user = User::factory()->create();
        $newTodo = new CreateTodoDTO('test todo', 'test description', now(), $user->id);

        $createNewTodoAction = new CreateNewTodo();

        $todo = $createNewTodoAction->handle($newTodo);

        $this->assertDatabaseHas('todos', [
            'todo' => $todo->todo,
            'description' => $todo->description,
            'expireAt' => $todo->expireAt,
            'userId' => $todo->userId,
        ]);

        $updateTodoAction = new UpdateTodo();

        $updatingTodoData = new UpdateTodoDTO($todo->id, "test test 2", "test test 4", now()->addDays(2), $user->id);

        $updatedTodo = $updateTodoAction->handle($updatingTodoData);

        $this->assertDatabaseHas('todos', [
            'todo' => $updatingTodoData->todo,
            'description' => $updatingTodoData->description,
            'expireAt' => $updatingTodoData->expireAt,
            'userId' => $updatingTodoData->userId,
        ]);
    }

    public function test_get_todo_actions(): void
    {
        $user = User::factory()->create();
        $newTodo = new CreateTodoDTO('test todo', 'test description', now(), $user->id);

        $createNewTodoAction = new CreateNewTodo();

        $todo = $createNewTodoAction->handle($newTodo);

        $this->assertDatabaseHas('todos', [
            'todo' => $todo->todo,
            'description' => $todo->description,
            'expireAt' => $todo->expireAt,
            'userId' => $todo->userId,
        ]);

        $getTodoAction = new GetTodo();

        $retrivedTodo = $getTodoAction->handle($todo->id);

        $this->assertNotNull($retrivedTodo);
        $this->assertEquals($newTodo->todo, $retrivedTodo->todo);
        $this->assertEquals($newTodo->description, $retrivedTodo->description);
        $this->assertEquals($newTodo->expireAt, $retrivedTodo->expireAt);
        $this->assertEquals($newTodo->userId, $retrivedTodo->userId);
    }

    public function test_get_all_todos_actions(): void
    {
        $user = User::factory()->create();
        $newTodo1 = new CreateTodoDTO('test todo1', 'test description', now(), $user->id);
        $newTodo2 = new CreateTodoDTO('test todo2', 'test description', now(), $user->id);
        $newTodo3 = new CreateTodoDTO('test todo3', 'test description', now(), $user->id);
        $newTodo4 = new CreateTodoDTO('test todo4', 'test description', now(), $user->id);
        $newTodo5 = new CreateTodoDTO('test todo5', 'test description', now(), $user->id);

        $createNewTodoAction = new CreateNewTodo();

        $todo = $createNewTodoAction->handle($newTodo1);
        $todo = $createNewTodoAction->handle($newTodo2);
        $todo = $createNewTodoAction->handle($newTodo3);
        $todo = $createNewTodoAction->handle($newTodo4);
        $todo = $createNewTodoAction->handle($newTodo5);

        $getAllTodoAction = new GetAllTodo();

        $retrivedTodos = $getAllTodoAction->handle($user->id);

        $this->assertCount(5, $retrivedTodos);
    }
}
