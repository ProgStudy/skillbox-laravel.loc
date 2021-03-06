<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleFormRequest;
use App\Models\Article;
use App\Models\Observers\ArticleObserver;
use App\Models\User;
use App\Services\ExternalAPIRest\PushAll;
use App\Services\TagsSynchronizer;
use Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

        $articles = Cache::tags(['articles'])->rememberForever('ArticleController:index_' . request()->get('page', 1), function () {
            return User::hasRoleByAuth(['admin']) ? Article::paginate(20) : Article::allByOwner()->paginate(20);
        });
        
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
    public function store(TagsSynchronizer $tSync, ArticleFormRequest $request, PushAll $pushAll)
    {
        $this->nextByRoleAjax(['admin', 'author']);

        try {
            $article = Article::create(array_merge($request->allCorrectFields(), ['owner_id' => Auth::user()->id, 'created_at' => now(), 'updated_at' => now()]));
            $tSync->sync(collect(explode(',', request('tags'))), $article);
            $pushAll->send('Была создана новая статья!', $article->name, env('APP_URL') . '/' . $article->slug);
        } catch (\Throwable $th) {
            Log::debug($th->getMessage());
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
        $article = Cache::tags(['articles'])->rememberForever('ArticleController:index_' . $slug, function () use ($slug) {
            return Article::findBySlug($slug);
        });

        if (!$article) {
            return abort(404);
        }

        if ($article->has_public != 1) {
            if ((User::hasRoleByAuth('admin') || Auth::check() && Auth::user()->id == $article->owner_id)) {
                return view('article', ['article' => $article]);
            } else {
                return abort(403);
            }
        }

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
        $this->nextByRole(['admin', 'author']);

        if (!$article->hasOwner() && !User::hasRoleByAuth(['admin'])) {
            return abort(403);
        }

        return view('admin.articles.form.edit', ['article' => $article]);
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
