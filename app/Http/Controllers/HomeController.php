<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Article;
use App\Models\ArticleHistory;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\News;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;

class HomeController extends Controller
{
    public function index()
    {
        $articles = Article::where(function($q) {
            if (!User::hasRoleByAuth(['admin'])) {
                if (User::hasRoleByAuth(['author'])) {
                    $q->where('has_public', 1)->orWhere('owner_id', Auth::user()->id);
                } else {
                    $q->where('has_public', 1);
                }
            }
        })->orderBy('created_at', 'desc')->paginate(10);

        return view('home', ['articles' => $articles]);
    }

    public function statistic()
    {
        $result = [
            [
                'name' => 'Общее количество статей', 
                'value' => Article::count()
            ],
            [
                'name' => 'Общее количество новостей', 
                'value' => News::count()
            ],
            [
                'name' => 'ФИО автора, у которого больше всего статей на сайте' , 
                'value' => ''
            ],
            [
                'name' => 'Самая длинная статья' , 
                'value' => ''
            ],
            [
                'name' => 'Самая короткая статья' , 
                'value' => ''
            ],
            [
                'name' => 'Среднее количество статей у активных пользователей' , 
                'value' => ''
            ],
            [
                'name' => 'Самая непостоянная' , 
                'value' => ''
            ],
            [
                'name' => 'Самая обсуждаемая статья' , 
                'value' => ''
            ]
        ];

        //больше всего статей
        $article = Article::selectRaw('owner_id, count(id) as lengs')
                ->groupBy('owner_id')
                ->orderBy('lengs', 'desc')
                ->with('user')
                ->first();

        $result[2]['value'] = $article->user->name;

        //самая длинная и короткая статья
        $articleQuery = Article::selectRaw('length(description) as countDesc, name, concat("/articles/", slug) as link');
        
        $article = (clone ($articleQuery))->orderBy('countDesc', 'desc')->first();
        $result[3]['value'] = "<a href='$article->link'>$article->name</a> | Количество символов: $article->countDesc";

        $article = (clone ($articleQuery))->orderBy('countDesc', 'asc')->first();
        $result[4]['value'] = "<a href='$article->link'>$article->name</a> | Количество символов: $article->countDesc";

        //среднее количество статей у активных пользователей
        $result[5]['value'] = round(Article::selectRaw('count(id) as counts')->groupBy('owner_id')->having('counts', '>', 1)->avg('counts'));

        //Самая непостоянная
        $history = ArticleHistory::selectRaw('count(article_id) as counts, article_id')
                    ->groupBy('article_id')
                    ->orderBy('counts', 'desc')
                    ->with('article')
                    ->first();

        $result[6]['value'] = "<a href='/articles/" . $history->article->slug . "'>" . $history->article->name . "</a>";

        //Самая обсуждаемая
        $article = Comment::selectRaw('articles.name as name, concat("/articles/", articles.slug) as link, count(comments.id) as counts')
                    ->leftJoin('commentables', 'commentables.comment_id', '=', 'comments.id')
                    ->leftJoin('articles', 'articles.id', '=', 'commentables.commentable_id')
                    ->where('commentables.commentable_type', "App\Models\Article")
                    ->groupBy('commentables.commentable_id')
                    ->orderBy('counts', 'desc')
                    ->first();

        $result[7]['value'] = "<a href='$article->link'>$article->name</a>";

        return view('statisic', compact('result'));
    }

    public function news()
    {
        $news = News::paginate(10);
        return view('news', ['news' => $news]);
    }

    public function about()
    {
        return view('about');
    }

    public function contacts()
    {
        return view('contacts');
    }

    /**
     * ajaxSendContact function
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxSendContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'         => 'required|regex:/^([A-z0-9]+\@+[a-z0-9]+\.+[a-z]{2,3})$/i',
            'description'   => 'required'
        ]);

        if ($validator->fails()) {
            return $this->ajaxError($validator->errors()->first());
        }

        $contact                = new Contact();

        $contact->email         = $request->email;
        $contact->description   = $request->description;

        try {
            $contact->save();
        } catch (Exception $e) {
            return $this->ajaxError('Не удалось сохранить контактные данные!');
        }

        return $this->ajaxSuccess('Контактные данные были отправлены!');
    }
}
