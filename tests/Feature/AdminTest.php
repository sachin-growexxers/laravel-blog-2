<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Tests\TestCase;

class AdminTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_user_without_logged_in()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                    ->withSession([])
                    ->get('/login');
        $response->assertStatus(302);
        
    }

    public function test_authenticated_user_can_see_all_post()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                    ->withSession([
                        'user_id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email
                    ]);
        $posts = Post::factory()->create();
        $response = $this->get('admin');
        $response->assertStatus(200);
        $response->assertViewIs('admin.index');
        $response->assertViewHas('posts');
    }

    public function test_unauthenticated_user_cant_see_all_post()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_post_belongs_to_user()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $post->user);
    }

    public function test_user_has_many_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->assertTrue($user->posts->contains($post));
    }
}