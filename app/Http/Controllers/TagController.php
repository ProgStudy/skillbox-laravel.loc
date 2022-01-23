<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;
use Cache;
use Illuminate\Http\Request;

class TagController extends Controller
{

    /**
     * index function
     *
     * @param Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function index(Tag $tag)
    {
        $results = Cache::tags(['news', 'articles'])->rememberForever('TagController:index_' . $tag->id, function () use ($tag) {
            $results = [
                'collectArticles' => $tag->articles()->with('tags')->get(),
                'collectNews'     => $tag->news()->with('tags')->get()
            ];

            return (object) $results;
        });
 
        return view('list-by-tag', [
            'collectArticles' => $results->collectArticles,
            'collectNews'     => $results->collectNews
        ]);
    }
}
