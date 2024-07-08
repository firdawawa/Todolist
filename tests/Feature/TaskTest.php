<?php

namespace Tests\Feature;

use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Carbon;

class TaskTest extends TestCase
{
    use RefreshDatabase;


    public function test_task_index() {
        $this->withoutExceptionHandling();
        $task = Item::factory()->create(['name' => 'Task Test']);
        $response = $this->json('get', '/api/items');
        $response->assertStatus(200);
        $response->assertJsonPath('0.title', $task->title);
    }


    public function test_task_store()
    {
        $this->withoutExceptionHandling();

        $response = $this->json('post', '/api/item/store', [
            'item' => ['name' => 'New Task']
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'name' => 'New Task'
        ]);

        $this->assertDatabaseHas('items', [
            'name' => 'New Task'
        ]);
    }

    public function test_task_update()
    {
        $this->withoutExceptionHandling();

        $task = Item::factory()->create([
            'name' => 'Old Task',
            'completed' => false,
            'completed_at' => null,
        ]);

        $response = $this->json('put', "/api/item/{$task->id}", [
            'item' => ['completed' => true]
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'completed' => true,
            'completed_at' => true // Note: the Carbon timestamp is not directly tested here
        ]);

        $this->assertDatabaseHas('items', [
            'id' => $task->id,
            'completed' => true,
            'completed_at' => Carbon::now(), // You might need to adjust this check to handle timestamps properly
        ]);
    }

    public function test_task_destroy()
    {
        $this->withoutExceptionHandling();

        $task = Item::factory()->create([
            'name' => 'Task to be deleted'
        ]);

        $response = $this->json('delete', "/api/item/{$task->id}");

        $response->assertStatus(200);
        $response->assertSee('Successfully deleted');

        $this->assertDatabaseMissing('items', [
            'id' => $task->id,
        ]);
    }
}
