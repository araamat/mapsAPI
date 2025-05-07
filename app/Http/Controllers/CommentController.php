<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     */
    public function store(Post $post, Request $request)
    {
        $data = $request->validate([
            'comment' => 'required|string',
        ]);

        $post->comments()->create([
            'body' => $data['comment'],
            'user_id' => auth()->id(),
        ]);

        return redirect()->back(); // ← oluline
    }

    /**
     * Remove the specified comment from storage.
     */
    public function destroy(Comment $comment)
    {
        // Kontrollime, kas kasutaja on admin või kommentaari autor
        if (Auth::user()->id === $comment->user_id || Auth::user()->is_admin) {
            $comment->delete();
            return response()->json(['message' => 'Kommentaar kustutatud.']);
        }

        return response()->json(['message' => 'Pole õigusi seda kommentaari kustutada.'], 403);
    }
}
