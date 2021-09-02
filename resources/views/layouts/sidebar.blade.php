<div class="col-md-4 blog-main">
    <h3 class="pb-3 mb-4 font-italic border-bottom">Теги</h3>
    <div style="background-color: #d9f8ff">
        @foreach ($tagsCloud as $tag)
            <a class="badge badge-secondary" href="/articles/tags/{{$tag->name}}">{{$tag->name}}</a>
        @endforeach
    </div>
</div>