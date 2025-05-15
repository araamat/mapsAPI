<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class PostController extends Controller
{
    use AuthorizesRequests;

    public function index()
{
    return Inertia::render('post/Index', [
        'posts' => Post::with('user')->get()->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'created_at_for_humans' => $post->created_at->diffForHumans(),
                'canManage' => auth()->check() && (auth()->user()->is_admin || auth()->id() === $post->user_id),
            ];
        }),
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

        Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->id(), // autor määratakse siit
        ]);

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
        $this->authorize('manage', $post);

        return Inertia::render('post/Edit', [
            'post' => $post
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('manage', $post);

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        $post->update($request->only(['title', 'description']));

        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        $this->authorize('manage', $post);

        $post->delete();

        return redirect()->route('posts.index');
    }
}
