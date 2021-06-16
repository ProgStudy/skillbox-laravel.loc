@extends('layouts.index')

@section('title', 'Контакты')

@section('content')
<div class="row">

    <div class="col-md-8 blog-main">
        <h3 class="pb-3 mb-4 font-italic border-bottom">Контакты</h3>
        <form action="/contacts/ajax/send" method="post" data-redirect="/contacts">
            @csrf
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email">
            </div>
            <div class="form-group">
                <label>Сообщение</label>
                <textarea type="text" class="form-control" name="description" style="resize:vertical; height: 150px;"></textarea>
            </div>
            <div class="form-group">
                <label>&nbsp;</label>
                <button class="btn btn-primary  w-100">Отправить</button>
            </div>
        </form>
    </div><!-- /.blog-main -->

</div><!-- /.row -->
@endsection
