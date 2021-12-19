@extends('layouts.index')

@section('title', 'Список статей')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h3 class="pb-3 mb-4 font-italic border-bottom">Редактирование статьи</h3>
        <form action="/admin/news/{{$itemNews->id}}" method="put" data-redirect="/admin/news">
            @include("admin.news.form.index", ['itemNews' => $itemNews])
        </form>
    </div>
</div><!-- /.row -->
@endsection
