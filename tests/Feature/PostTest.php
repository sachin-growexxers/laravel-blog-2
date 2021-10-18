<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Faker\Factory;
use Illuminate\Auth\Access\AuthorizationException;
use Tests\TestCase;

class PostTest extends TestCase
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

    public function testPostIndexView()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                    ->withSession([
                        'user_id' => $user->id, 
                        'name' => $user->name, 
                        'email' => $user->email
                    ]);
        $response = $this->get('/dashboard');
        $response->assertStatus(200);
    }

    public function testPostCreateView()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                    ->withSession([
                        'user_id' => $user->id, 
                        'name' => $user->name, 
                        'email' => $user->email
                    ]);

        $response = $this->call('GET', 'admin/posts/create');
        $response->assertStatus(200);
    }
    
    public function testPostStoreView()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                    ->withSession([
                        'user_id' => $user->id, 
                        'name' => $user->name, 
                        'email' => $user->email
                    ]);
        
        $category = Category::factory()->create();
        $posts = Post::create([
            'user_id' => $user->id,
            'title' => 'This is blog title',
            'slug' => 'This is blog slug',
            'excerpt' => 'This is blog excerpt',
            'thumbnail' => Factory::create()->imageUrl(440,500),
            'body' => 'This is blog body',
            'category_id' => $category->id
        ]);

        $response = $this->call('GET', 'admin/', ['_token' => csrf_token()]);
        $response->assertStatus(200);
        $response->assertViewHas('posts');
        $this->assertDatabaseHas('posts', [
            'title' => 'This is blog title'
        ]);
    }

    public function testPostShowView()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                    ->withSession([
                        'user_id' => $user->id, 
                        'name' => $user->name, 
                        'email' => $user->email
                    ]);

        $category = Category::factory()->create();
        $post = Post::create([
            'user_id' => $user->id,
            'title' => 'This is blog title',
            'excerpt' => 'This is blog excerpt',
            'thumbnail' => Factory::create()->imageUrl(440,500),
            'body' => 'This is blog body',
            'category_id' => $category->id
        ]);

        $response = $this->call('GET', 'post/' . $post->id);
        $response->assertStatus(200);
    }

    // public function testPostShowViewWithAuthenticatedUser()
    // {
    //     $user = User::factory()->create();

    //     $response = $this->actingAs($user)
    //                 ->withSession([
    //                     'user_id' => $user->id,
    //                     'name' => $user->name,
    //                     'email' => $user->email
    //                 ]);

    //     $category = Category::factory()->create();
    //     $post = Post::create([
    //         'user_id' => $user->id,
    //         'title' => 'This is blog title',
    //         'excerpt' => 'This is blog excerpt',
    //         'thumbnail' => Factory::create()->imageUrl(440,500),
    //         'body' => 'This is blog body',
    //         'category_id' => $category->id
    //     ]);

    //     $response = $this->call('GET', 'post/' . $post->id);
    //     $response->assertStatus(200);
    // }

    public function testPostEditView()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
                    ->withSession([
                        'user_id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email
                    ]);
        
        $category = Category::factory()->create();
        $post = Post::create([
            'user_id' => $user->id,
            'title' => 'This is blog title',
            'excerpt' => 'This is blog excerpt',
            'thumbnail' => Factory::create()->imageUrl(440,500),
            'body' => 'This is blog body',
            'category_id' => $category->id
        ]);

        $response = $this->call('GET', 'admin/posts/' . $post->id  .'/edit', ['_token' => csrf_token()]);
        $response->assertStatus(200);
        $response->assertViewIs('admin.edit');
        $response->assertViewHas('post');
    }

    public function testPostUpdateView()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
                    ->withSession([
                        'user_id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email
                    ]);

        $category = Category::factory()->create();
        $mainPost = Post::create([
            'user_id' => $user->id,
            'title' => 'This is blog title',
            'excerpt' => 'This is blog excerpt',
            'slug' => 'This is blog slug',
            'thumbnail' => Factory::create()->imageUrl(440,500),
            'body' => 'This is blog body',
            'category_id' => $category->id
        ]);

        $updatedPost = array(
            'title' => 'This is updated blog title',
            'excerpt' => 'This is updated blog excerpt',
            'slug' => 'This is updated blog slug',
            'thumbnail' => Factory::create()->imageUrl(440,500),
            'body' => 'This is updated blog body',
            'category_id' => $category->id
        );

        $response = $this->call('PATCH', 'admin/posts/' . $mainPost->id . '/update', $updatedPost , ['_token' => csrf_token()]);
        $response->assertStatus(302);
        $response->assertRedirect('admin/posts');
        
        $response->assertViewIs('admin.update');
        $this->assertDatabaseHas('posts', [
            'title' => 'This is updated blog title'
        ]);
    }

    // public function testPostDeleteView()
    // {
    //     //$this->expectException(AuthorizationException::class);
    //     //$this->withoutExceptionHandling();
    //     $user = User::factory()->create();
    //     $response = $this->actingAs($user)
    //                 ->withSession([
    //                     'user_id' => $user->id,
    //                     'name' => $user->name,
    //                     'email' => $user->email
    //                 ]);
        
    //     $category = Category::factory()->create();
    //     $post = Post::factory()->create();

    //     $response = $this->call('DELETE' , 'admin/posts/' . $post->id .'/destroy');
    //     $response->assertFalse(Post::where('id', $post->id)->exists());
    //     $response->assertStatus(200);
    //     $response->assertViewIs('dashboard');
    //     $response->assertViewHas('posts');
    // }
}