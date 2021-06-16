@extends('layouts.index')

@section('title', 'Админ. панель')

@section('content')
<div class="row">

    <div class="col-md-8 blog-main">
        <h3 class="pb-3 mb-4 font-italic border-bottom">Админ. панель</h3>
        <div>
            <a href="/admin/feedback">Список обращений</a>
        </div>
        <br>
    </div><!-- /.blog-main -->

</div><!-- /.row -->
@endsection