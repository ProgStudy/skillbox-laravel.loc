<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{

    /**
     * Undocumented function
     *
     * @param Tag $tag
     * @return void
     */
    public function index(Tag $tag)
    {
        $articles = $tag->articles()->with('tags')->get();
        return view('home', compact(['articles']));
    }
}
