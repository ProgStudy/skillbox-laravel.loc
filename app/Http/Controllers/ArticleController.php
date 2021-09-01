<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleFormRequest;
use App\Models\Article;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::all();
        return view('admin.articles.index', ['articles' => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.articles.form.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ArticleFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleFormRequest $request)
    {
        try {
            Article::create(array_merge($request->allCorrectFields(), ['created_at' => now(), 'updated_at' => now()]));
        } catch (\Throwable $th) {
            return $this->ajaxError('Не удалось добавить новую статью!');
        }

        return $this->ajaxSuccess('Статья успешно добавлена!');
    }

    /**
     * Display the specified resource.
     *
     * @param  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $article = Article::findBySlug($slug);

        if (!$article) return abort(404);

        return view('article', ['article' => $article]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        return view('admin.articles.form.edit', ['artice' => $article]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\ArticleFormRequest  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleFormRequest $request, Article $article)
    {
        try {
            $article->fill((array) $request->allCorrectFields())->save();
        } catch (\Throwable $th) {
            return $this->ajaxError('Не удалось обновить статью!');
        }

        return $this->ajaxSuccess('Статья успешно обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        try {
            $article->delete();
        } catch (\Throwable $th) {
            return $this->ajaxError('Не удалось удалить статью!');
        }
        
        return $this->ajaxSuccess('Статья успешна удалена!');
    }
}
