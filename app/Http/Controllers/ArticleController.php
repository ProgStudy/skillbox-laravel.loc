<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleFormRequest;
use App\Models\Article;
use App\Models\Observers\ArticleObserver;
use App\Models\User;
use App\Services\TagsSynchronizer;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{

    public function __construct()
    {
        Article::observe(new ArticleObserver());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->nextByRole(['admin', 'author']);
        $articles = User::hasRole(['admin']) ? Article::all() : Article::allByOwner();
        return view('admin.articles.index', ['articles' => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->nextByRole(['admin', 'author']);
        return view('admin.articles.form.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ArticleFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagsSynchronizer $tSync, ArticleFormRequest $request)
    {
        $this->nextByRoleAjax(['admin', 'author']);

        try {
            $article = Article::create(array_merge($request->allCorrectFields(), ['owner_id' => Auth::user()->id, 'created_at' => now(), 'updated_at' => now()]));
            $tSync->sync(collect(explode(',', request('tags'))), $article);
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

        if (!$article) {
            return abort(404);
        }

        if ($article->has_public != 1 && (User::hasRole('admin') || Auth::check() && Auth::user()->id == $article->owner_id)) {
            return view('article', ['article' => $article]);
        } else {
            return abort(403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $this->nextByRole(['admin', 'author']);

        if (!$article->hasOwner() && !User::hasRole(['admin'])) {
            return abort(403);
        }
        
        return view('admin.articles.form.edit', ['artice' => $article]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\ArticleFormRequest  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(TagsSynchronizer $tSync, ArticleFormRequest $request, Article $article)
    {
        $this->nextByRoleAjax(['admin', 'author']);

        try {
            $article->fill((array) $request->allCorrectFields(), ['updated_at' => now()])->save();
            $tSync->sync(collect(explode(',', request('tags'))), $article);
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
        $this->nextByRoleAjax(['admin', 'author']);

        try {
            $article->delete();
        } catch (\Throwable $th) {
            return $this->ajaxError('Не удалось удалить статью!');
        }
        
        return $this->ajaxSuccess('Статья успешна удалена!');
    }
}
