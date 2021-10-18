<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testHomeIndexView()
    {
        $category = Category::factory()->create();

        $posts = Post::create([
            'title' => 'This is blog title',
            'excerpt' => 'This is blog excerpt',
            'thumbnail' => 'images/avatar.jpg',
            'body' => 'This is blog body',
            'category_id' => $category->id
        ]);

        $response = $this->get('/');
        $response->assertViewHas('posts');
    }

    public function test_show_all_posts()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('welcome');
        $response->assertViewHas('posts');
    }

    public function test_show_post_details()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $post = Post::create([
            'user_id' => $user->id,
            'title' => 'This is blog title',
            'excerpt' => 'This is blog excerpt',
            'thumbnail' => 'images/avatar.jpg',
            'body' => 'This is blog body',
            'category_id' => $category->id
        ]);

        $response = $this->call('GET', 'home/' . $post->id , ['_token' => csrf_token()]);
        $response->assertViewHas('post');
        $response->assertStatus(200);
    }
}