<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        return Inertia::render('post/Index', [
            'posts' => Post::all(),
        ]);
    }

    public function create()
    {
        return Inertia::render('post/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        Post::create($request->only(['title', 'description']));

        return redirect()->route('posts.index');
    }

    

    public function show(Post $post)
{
    $post->load([
        'comments' => fn ($q) => $q->latest(),
        'comments.user',
    ]);

    return Inertia::render('post/Show', [
        'post' => $post
    ]);
}


    public function edit(Post $post)
    {
        return Inertia::render('post/Edit', [
            'post' => $post
        ]);
    }
    

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        $post->update($request->only(['title', 'description']));

        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index');
    }
}
