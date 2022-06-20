<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class CommentController extends Controller
{
    private $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function store(Request $request, $post_id)
    {
        $request->validate([
            'comment' => 'required|min:1|max:150'
        ]);

        $this->comment->user_id = Auth::user()->id; // Who created the comment
        $this->comment->post_id = $post_id; // What post was commented
        $this->comment->body    = $request->comment; // What is the comment
        $this->comment->save();

        return redirect()->back();
    }

    public function destroy($id)
    {
        # Eloquent
        $this->comment->destroy($id);
        return redirect()->back();

        # Qry Builder 1
        // $comment = $this->comment->findOrFail($id);
        // $comment->delete();

        # Qry Builder 2
        // $this->comment->findOrFail($id)->delete(); // very similar with destroy

        # Qry Builder 3
        // $this->comment->where('user_id', $user_id)->where('post_id', $post_id)->delete();
    }
}
