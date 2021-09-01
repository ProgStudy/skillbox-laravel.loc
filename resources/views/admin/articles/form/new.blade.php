@extends('layouts.index')

@section('title', 'Список статей')

@section('content')
<div class="row">
    <div class="col-md-8">
        <h3 class="pb-3 mb-4 font-italic border-bottom">Новая статья</h3>
        <form action="/admin/articles" method="post" data-redirect="/admin/articles">
            @include("admin.articles.form.index")
        </form>
    </div>
</div><!-- /.row -->
@endsection