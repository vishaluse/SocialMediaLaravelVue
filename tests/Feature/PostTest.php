<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PostTest extends TestCase
{


    /**
     * A basic test example.
     *
     * @return void
     */
    use RefreshDatabase;
    use WithoutMiddleware;


    public function test_if_registerapi_is_working()
    {
        $this->post('api/register/',['name'=> 'vishal', 'username'=>'vishal', 'email'=> 'vishal@gmail.com', 'password' => '1111', 'password_confirmation' => '1111']);
        $this->assertCount(1, User::all());
    }

    public function test_if_logiapi_is_working()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create(['password'=>'1111']);
        $this->post('api/login/',['email'=> $user->email, 'password'=> '1111']);
        $this->assertAuthenticated($guard=null);
    }

    public function test_if_post_can_be_created_and_deleted() {
        $this->withoutExceptionHandling();
        $post = Post::factory()->create();
        $this->assertCount(1, Post::all());
        $response = $this->delete('api/postapi/'.$post->first()->slug);
        $response->assertStatus(200);
    }

}
