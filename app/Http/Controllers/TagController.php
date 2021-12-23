<?php

namespace App\Http\Controllers;

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
        $articles = $tag->articles()->with('tags')->paginate(10);
        return view('home', compact(['articles']));
    }
}
