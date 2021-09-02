@extends('layouts.index')

@section('title', 'Главная')

@section('content')
<div class="row">

    <div class="col-md-8 blog-main">
        <h3 class="pb-3 mb-4 font-italic border-bottom">Статьи</h3>

        @foreach($articles as $article)
        <div class="blog-post">
            <h2 class="blog-post-title"><a href="/articles/{{$article->slug}}">{{$article->name}}</a></h2>
            <p class="blog-post-meta">{{date('F d, Y', strtotime($article->created_at))}}</p>
            <p>{{$article->preview}}</p>
            <div>
                @foreach ($article->tags as $tag)
                <span class="badge badge-secondary">{{$tag->name}}</span>   
                @endforeach
            </div>
        </div><!-- /.blog-post -->
        @endforeach

    </div><!-- /.blog-main -->
    @include('layouts.sidebar')

</div><!-- /.row -->
@endsection
