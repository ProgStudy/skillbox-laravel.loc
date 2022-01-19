@extends('layouts.index')

@section('title', 'Главная')

@section('content')
<div class="row">

    <div class="col-md-8 blog-main">
        <h3 class="pb-3 mb-4 font-italic">Список по тегу</h3>

        <div>
            <h5>Новости</h5>
            <hr>
        </div>

        @foreach($collectNews as $collect)
        <div class="blog-post">
            <h2 class="blog-post-title"><a href="/news/{{$collect->slug}}">{{$collect->name}}</a></h2>
            <p class="blog-post-meta">{{date('F d, Y', strtotime($collect->created_at))}}</p>
            <p>{{$collect->preview}}</p>
            <div>
                @foreach ($collect->tags as $tag)
                <span class="badge badge-secondary">{{$tag->name}}</span>
                @endforeach
            </div>
        </div><!-- /.blog-post -->
        @endforeach

        <div>
            <h5>Статьи</h5>
            <hr>
        </div>
        @foreach($collectArticles as $collect)
        <div class="blog-post">
            <h2 class="blog-post-title"><a href="/articles/{{$collect->slug}}">{{$collect->name}}</a></h2>
            <p class="blog-post-meta">{{date('F d, Y', strtotime($collect->created_at))}}</p>
            <p>{{$collect->preview}}</p>
            <div>
                @foreach ($collect->tags as $tag)
                <span class="badge badge-secondary">{{$tag->name}}</span>
                @endforeach
            </div>
        </div><!-- /.blog-post -->
        @endforeach

    </div><!-- /.blog-main -->
    @include('layouts.sidebar')

</div><!-- /.row -->
@endsection
