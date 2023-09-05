<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_todo_list_render(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get("/dashboard");

        $response->assertStatus(200);
    }

    public function test_create_todo_page_render(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get("/todo/create");

        $response->assertStatus(200);
    }

    public function test_add_todo_correctly(): void
    {
        $user = User::factory()->create();

        $expireAt = now()->addDay();
        $this->actingAs($user)->post("/todo/create", [
            'todo' => 'test',
            'description' => 'test',
            'expireAt' => $expireAt,
            'userId' => $user->id
        ]);

        $this->assertDatabaseHas('todos', [
            'todo' => 'test',
            'description' => 'test',
            'expireAt' => $expireAt,
            'userId' => $user->id
        ]);
    }

    public function test_complete_todo_correctly(): void
    {
        $user = User::factory()->create();

        $expireAt = now()->addDay();
        $this->actingAs($user)->post("/todo/create", [
            'todo' => 'test',
            'description' => 'test',
            'expireAt' => $expireAt,
            'userId' => $user->id
        ]);

        $todos = $user->load('todos')->todos[0];

        $this->actingAs($user)->post(
            "/todo/complete",
            [
                'id' => $todos->id
            ]
        );

        $todos = $user->load('todos')->todos[0];

        $this->assertNotNull($todos->completedAt);
    }

    public function test_todo_deleted_successfully(): void
    {
        $user = User::factory()->create();

        $expireAt = now()->addDay();
        $this->actingAs($user)->post("/todo/create", [
            'todo' => 'test',
            'description' => 'test',
            'expireAt' => $expireAt,
            'userId' => $user->id
        ]);

        $todos = $user->load('todos')->todos[0];

        $this->actingAs($user)->delete(
            "/todo",
            [
                'id' => $todos->id
            ]
        );

        $todos = $user->load('todos')->todos;

        $this->assertEmpty($todos);
    }

    public function test_todo_edit_page_render_correctly(): void
    {
        $user = User::factory()->create();

        $expireAt = now()->addDay();
        $this->actingAs($user)->post("/todo/create", [
            'todo' => 'test',
            'description' => 'test',
            'expireAt' => $expireAt,
            'userId' => $user->id
        ]);

        $todos = $user->load('todos')->todos[0];

        $response = $this->actingAs($user)->get("/todo/" . $todos->id . "/edit");

        $response->assertStatus(200);
    }

    public function test_todo_edited_correctly(): void
    {
        $user = User::factory()->create();

        $expireAt = now()->addDay();
        $this->actingAs($user)->post("/todo/create", [
            'todo' => 'test',
            'description' => 'test',
            'expireAt' => $expireAt,
            'userId' => $user->id
        ]);

        $todos = $user->load('todos')->todos[0];

        $expireAt = $expireAt->addDays(2);

        $this->actingAs($user)->put("/todo/update", [
            'id' => $todos->id,
            'todo' => 'test2',
            'description' => 'test2',
            'expireAt' => $expireAt,
        ]);

        $this->assertDatabaseHas('todos', [
            'id' => $todos->id,
            'todo' => 'test2',
            'description' => 'test2',
            'expireAt' => $expireAt,
            'userId' => $user->id
        ]);
    }
}
