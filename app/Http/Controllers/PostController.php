<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /* function to show all blog posts */
    public function index()
    {
        $posts = auth()->user()->posts;
        return view('admin.index', [
            'posts' => $posts
        ])->with('message', 'You\'re logged in!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    /* function to create blog post */
    public function create()
    {
        $this->authorize('create', Post::class);
        $categories = Category::where('deleted_at', null)
                        ->latest()
                        ->get();
        return view('admin.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /* function to save blog post details */
    public function store(Request $request)
    {
        $this->authorize('create', Post::class);
        $inputs = request()->validate([
            'title' => 'required|min:5|max:255',
            'excerpt' => 'required|min:5|max:255',
            'thumbnail' => 'max:2048',
            'body' => 'required|min:5|max:255',
            'category_id' => 'required|integer'
        ]);

        if (request('thumbnail')) {
            $inputs['thumbnail'] = 'storage/'. request('thumbnail')->store('images');
        }

        auth()->user()->posts()->create($inputs);
        return redirect()->route('post.index')->with('message', 'Blog was added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /* function to show single blog post */
    public function show(Post $post)
    {
        $this->authorize('view', $post);
        $categories = Category::where('deleted_at', null)
                    ->latest()
                    ->get();
        return view('admin.show', [
            'post' => $post,
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /* function to show single blog post for edit purpose */
    public function edit(Post $post)
    {
        $this->authorize('view', $post);
        $categories = Category::where('deleted_at', null)
                        ->latest()
                        ->get();
        return view('admin.edit', [
            'post' => $post,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /* function to update single blog post */
    public function update(Post $post)
    {
        $this->authorize('update', $post);
        //try {
            $inputs = request()->validate([
                'title' => 'required|min:5|max:255',
                'excerpt' => 'required|min:5|max:255',
                'thumbnail' => 'image|nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'body' => 'required|min:5|max:255',
                'category_id' => 'required|integer'
            ]);

            if (request('thumbnail')) {
                $inputs['thumbnail'] = request('thumbnail')->store('images');
                $post->thumbnail = 'storage/' . $inputs['thumbnail'];
            }
    
            $post->title =  $inputs['title'];
            $post->excerpt =  $inputs['excerpt'];
            $post->slug =  $inputs['excerpt'];
            $post->category_id =  $inputs['category_id'];
            $post->body =  $inputs['body'];

            auth()->user()->posts()->save($post);
            return redirect()->route('post.index')->with('message', 'Blog post updated successfully.');
        // } catch (\Illuminate\Validation\ValidationException $e ) {
        //     return \response($e->errors(),400);
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /* function to delete single blog post */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post = Post::findOrfail($post->id)->delete();
        return redirect()->route('post.index')->with('message', 'Blog deleted successfully.');
    }
}
