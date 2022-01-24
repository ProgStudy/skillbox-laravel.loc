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

            @if(Auth::check() && Auth::user()->id == $article->owner_id)
            <a href="/admin/articles/{{$article->id}}/edit" class="link">Редактировать</a>
            @endif

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
        <hr>
        @showHistory($article)
            <div class="card">
                <div class="card-header">
                    <h5>История изменений</h5>
                </div>
                <div class="card-body">
                    <div style="height: 200px; overflow-y: auto;">
                        @php
                            $histories = cache()->tags(['histories'])->rememberForever('article.blade.histories:' . $article->slug, function() use ($article){
                                return $article->histories;
                            });
                        @endphp
                        @forelse ($histories as $history)
                            <p>{{$history->email}} - {{$history->pivot->created_at->diffForHumans()}} <br> <b>До изменений:</b> {{$history->pivot->before}} <br> <b>После изменений:</b> {{$history->pivot->after}}</p>
                        @empty
                            <div class="no-comment">Пусто</div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endshowHistory
        <div>
            <h4>Комментарии</h4>
            <div>
                @php
                    $comments = cache()->tags(['comments'])->rememberForever('article.blade.comments:' . $article->slug, function() use ($article){
                        return $article->comments;
                    });
                @endphp
                @forelse ($comments as $comment)
                    <div class="card mt-10 mb-10">
                        <div class="card-body">
                            <div class="comment ">
                                <h5>{{$comment->user->name}}</h5>
                                <p>{{$comment->text}}</p>
                                <small class="comment-date">{{$comment->created_at->diffForHumans()}}</small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="no-comment">Пока отсутствуют комментарии</div>
                @endforelse
            </div>
        </div>
        <div>
            @auth
                <form action="/comments/ajax/send" method="get" data-redirect="/articles/{{$article->slug}}">
                    @csrf
                    <input type="hidden" name="id" value="{{$article->id}}">
                    <input type="hidden" name="type" value="article">
                    <textarea class="w-100 mb-10 p-10 no-resize form-control" style="height: 100px" name="text" placeholder="Сообщение"></textarea>
                    <p class="error-field text-danger"></p>
                    <button type="submit" class="mb-10 btn btn-success">Отправить</button>
                </form>
            @endauth
        </div>
    </div>
    <!-- /.blog-main -->

</div><!-- /.row -->
@endsection
