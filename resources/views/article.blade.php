@extends('layouts.index')

@section('title', $article->name)

@section('content')
<div class="row">

    <div class="col-md-8 blog-main">
        
        @auth
        <div>
            @admin
            <a href="/admin" class="link">Админ. раздел</a>
            @else
            <a href="/admin/articles/{{$article->id}}/edit" class="link">Редактировать</a>
            @endadmin
        </div>
        @endauth
        
        <div class="blog-post">
            <h2 class="blog-post-title">{{$article->name}}</h2>
            <p class="blog-post-meta">{{date('F d, Y', strtotime($article->created_at))}}</p>
            @foreach(explode("\n", $article->description) as $block)
                <p>{{$block}}</p><br>
            @endforeach
        </div>
    </div>
    <!-- /.blog-main -->

</div><!-- /.row -->
@endsection
