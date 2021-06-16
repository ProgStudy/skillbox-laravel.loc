<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Article;

use Validator;

class ArticleController extends Controller
{
    public function create()
    {
        return view('articles.form');
    }

    public function get($slug)
    {
        $article = Article::findBySlug($slug);
        if (!$article) return abort(404);

        return view('articles.info', ['article' => $article]);
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|min:5|max:255',
            'slug'          => 'required|regex:/^[A-z0-9]+(?:\-[A-z0-9]+)*$/u|max:255',
            'preview'       => 'required|max:255',
            'description'   => 'required',
            'hasPublic'     => 'nullable|boolean'
        ]);

        if ($validator->fails()) return $this->ajaxError($validator->errors()->first());
        
        $article = Article::findBySlug($request->slug);

        if ($article) return $this->ajaxError('С таким символьным кодом уже существует запись!');

        $article = new Article();

        $article->slug          = $request->slug;
        $article->name          = $request->name;
        $article->preview       = $request->preview;
        $article->description   = $request->description;
        $article->has_public    = isset($request->hasPublic) ? 1 : 0;

        try {
            $article->save();
        } catch (Exception $e) {
            return $this->ajaxError('Не удалось сохранить статью!');
        }

        return $this->ajaxSuccess('Запись успешна сохранена!');
    }
}
