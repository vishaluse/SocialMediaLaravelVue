<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    public function test_example()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('posts.index'); //that works yaay !
    }
}
