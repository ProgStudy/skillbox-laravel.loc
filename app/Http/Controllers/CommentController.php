<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentFormRequest;
use App\Models\Article;
use App\Models\Comment;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Undocumented function
     *
     * @param CommentFormRequest $request
     * @return Response
     */
    public function store(CommentFormRequest $request)
    {
        try {
            $comment = new Comment(['text' => $request->text, 'user_id' => Auth::user()->id, 'created_at' => now(), 'updated_at' => now()]);
            if ($request->type == 'news') {
                $collect = News::find($request->id);
            } else {
                $collect = Article::find($request->id);
            }

            if (!$collect) {
                return $this->ajaxError('Запись не найдена!');
            }

            $collect->comments()->save($comment);

        } catch (\Throwable $th) {
            return $this->ajaxError('Не удалось добавить комментарий!');
        }

        return $this->ajaxSuccess('Комментарий добавлен!');
    }
}
