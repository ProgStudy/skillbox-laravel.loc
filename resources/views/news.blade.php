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
    @else

        @section('title', 'Новости')

        <div class="row">

            <div class="col-md-12 blog-main">
                <h3 class="pb-3 mb-4 font-italic border-bottom">Новости</h3>

                @foreach($news as $item)
                <div class="blog-post">
                    <h2 class="blog-post-title"><a href="/news/{{$item->slug}}">{{$item->name}}</a></h2>
                    <p class="blog-post-meta">{{date('F d, Y', strtotime($item->created_at))}}</p>
                    <p>{{$item->preview}}</p>
                </div><!-- /.blog-post -->
                @endforeach

            </div><!-- /.blog-main -->

        </div><!-- /.row -->

        {{ $news->links() }}
    @endif

@endsection
