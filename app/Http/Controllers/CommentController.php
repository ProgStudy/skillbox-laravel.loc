<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentFormRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentFormRequest $request)
    {
        try {
            Comment::create(['text' => $request->text, 'user_id' => Auth::user()->id, 'article_id' => $request->article_id, 'created_at' => now(), 'updated_at' => now()]);
        } catch (\Throwable $th) {
            return $this->ajaxError('Не удалось добавить комментарий!');
        }

        return $this->ajaxSuccess('Комментарий добавлен!');
    }
}
