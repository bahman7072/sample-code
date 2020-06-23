<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = $this->commentSearch();

        $comments = $comments->whereApproved(1)->latest()->paginate(20);
        return view('admin.comments.all', compact('comments'));
    }

    public function unapproved()
    {
        $comments = $this->commentSearch();

        $comments = $comments->whereApproved(0)->latest()->paginate(20);
        return view('admin.comments.all', compact('comments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $comment->update(['approved' => 1]);

        alert()->success('نظر مورد نظر تایید شد');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        alert()->success('نظر با موفقیت حذف شد.');
        return back();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function commentSearch(): \Illuminate\Database\Eloquent\Builder
    {
        $comments = Comment::query();

        if ($keyword = \request('search')) {
            $comments->where('comment', 'LIKE', "%{$keyword}%")
                ->orWhereHas('user', function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', "%{$keyword}%");
                });
        }
        return $comments;
    }
}
