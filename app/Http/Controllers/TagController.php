<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;
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
        $collectArticles = $tag->articles()->with('tags')->get();
        $collectNews = $tag->news()->with('tags')->get();
 
        return view('list-by-tag', compact(['collectArticles', 'collectNews']));
    }
}
