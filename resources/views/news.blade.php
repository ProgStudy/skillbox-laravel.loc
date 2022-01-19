@extends('layouts.index')


@section('content')

    @if(isset($itemNews))
        @section('title', $itemNews->name)

        <div class="blog-post">
            <h2 class="blog-post-title">{{$itemNews->name}}</h2>
            <p class="blog-post-meta">{{date('F d, Y', strtotime($itemNews->created_at))}}</p>
            @foreach(explode("\n", $itemNews->description) as $block)
                <p>{{$block}}</p><br>
            @endforeach
        </div>
        <div>
            <h4>Комментарии</h4>
            <div>
                @forelse ($itemNews->comments as $comment)
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
                <form action="/comments/ajax/send" method="get" data-redirect="/news/{{$itemNews->slug}}">
                    @csrf
                    <input type="hidden" name="id" value="{{$itemNews->id}}">
                    <input type="hidden" name="type" value="news">
                    <textarea class="w-100 mb-10 p-10 no-resize form-control" style="height: 100px" name="text" placeholder="Сообщение"></textarea>
                    <p class="error-field text-danger"></p>
                    <button type="submit" class="mb-10 btn btn-success">Отправить</button>
                </form>
            @endauth
        </div>
    @else

        @section('title', 'Новости')

        <div class="row">

            <div class="col-md-8 blog-main">
                <h3 class="pb-3 mb-4 font-italic border-bottom">Новости</h3>

                @foreach($news as $item)
                <div class="blog-post">
                    <h2 class="blog-post-title"><a href="/news/{{$item->slug}}">{{$item->name}}</a></h2>
                    <p class="blog-post-meta">{{date('F d, Y', strtotime($item->created_at))}}</p>
                    <p>{{$item->preview}}</p>
                    <div>
                        @foreach ($item->tags as $tag)
                        <span class="badge badge-secondary">{{$tag->name}}</span>
                        @endforeach
                    </div>
                </div><!-- /.blog-post -->
                @endforeach
                
                {{ $news->links() }}

            </div><!-- /.blog-main -->
            
            @include('layouts.sidebar')

        </div><!-- /.row -->

    @endif

@endsection
