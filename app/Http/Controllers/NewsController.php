<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsFormRequest;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{

    public function __construct()
    {
        $this->nextByRoleAjax(['admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = News::paginate(20);
        return view('admin.news.index', ['news' => $news]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.news.form.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsFormRequest $request)
    {
        try {
            News::create(array_merge($request->allCorrectFields(), ['created_at' => now(), 'updated_at' => now()]));
        } catch (\Throwable $th) {
            Log::debug($th->getMessage());
            return $this->ajaxError('Не удалось добавить новость!');
        }

        return $this->ajaxSuccess('Новость успешно добавлена!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $news = News::findBySlug($slug);

        if (!$news) {
            return abort(404);
        }

        return view('news', ['itemNews' => $news]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        return view('admin.news.form.edit', ['itemNews' => $news]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(NewsFormRequest $request, News $news)
    {

        try {
            $news->fill((array) $request->allCorrectFields(), ['updated_at' => now()])->save();
        } catch (\Throwable $th) {
            return $this->ajaxError('Не удалось обновить новость!');
        }

        return $this->ajaxSuccess('Новость успешно обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        try {
            $news->delete();
        } catch (\Throwable $th) {
            return $this->ajaxError('Не удалось удалить новость!');
        }

        return $this->ajaxSuccess('Новость успешна удалена!');
    }
}
