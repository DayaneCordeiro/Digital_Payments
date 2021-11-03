<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_show()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_that_a_task_can_be_added()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/api/v1/users/1');
        $response->assertStatus(201);
        $this->assertTrue(count(Task::all()) > 1);
    }
}
