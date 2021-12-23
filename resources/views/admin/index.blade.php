@extends('layouts.index')

@section('title', 'Админ. панель')

@section('content')
<div class="row">

    <div class="col-md-12 blog-main">
        <h3 class="pb-3 mb-4 font-italic border-bottom">Админ. панель</h3>
            <ul>
                <li><a class="link d-block" href="/admin/articles">Список статей</a></li>
                <li><a class="link d-block" href="/admin/feedback">Список обращений</a></li>
                <li><a class="link d-block" href="/admin/news">Список новостей</a></li>
            </ul>
        <br>
    </div><!-- /.blog-main -->

</div><!-- /.row -->
@endsection
