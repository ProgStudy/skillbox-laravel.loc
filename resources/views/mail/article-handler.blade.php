@component('mail::message')
<p>{{$message}}</p>
<hr>
<h1 class="text-center">{{$article->name}}</h1>



@if (!isset($article->isDelete))

{{$article->preview}}

@component('mail::button', ['url' => '/articles/' . $article->slug])
Подробнее
@endcomponent

@else

{{$article->description}}

@endif

@endcomponent
