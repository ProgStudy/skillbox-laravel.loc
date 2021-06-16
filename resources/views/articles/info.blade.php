@extends('layouts.index')

@section('title', $article->name)

@section('content')
<div class="row">

    <div class="col-md-8 blog-main">
        <div class="blog-post">
            <h2 class="blog-post-title">{{$article->name}}</h2>
            <p class="blog-post-meta">{{date('F d, Y', strtotime($article->created_at))}}</p>
            @foreach(explode("\n", $article->description) as $block)
                <p>{{$block}}</p><br>
            @endforeach
        </div>
    </div><!-- /.blog-main -->

</div><!-- /.row -->
@endsection
