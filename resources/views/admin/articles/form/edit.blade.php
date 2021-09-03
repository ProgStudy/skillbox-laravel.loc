@extends('layouts.index')

@section('title', 'Список статей')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h3 class="pb-3 mb-4 font-italic border-bottom">Редактирование статьи</h3>
        <form action="/admin/articles/{{$artice->id}}" method="put" data-redirect="/admin/articles">
            @include("admin.articles.form.index", ['article' => $artice])
        </form>
    </div>
</div><!-- /.row -->
@endsection