<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentController extends Controller
{
    use AuthorizesRequests;
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'post_id' => 'required|exists:posts,id',
        ]);

        $request->user()->comments()->create([
            'post_id' => $request->post_id,
            'body' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Kommentaar lisatud!');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment); // 👈 Ainult adminil lubatud

        $comment->delete();

        return redirect()->back()->with('success', 'Kommentaar kustutatud!');
    }
}
