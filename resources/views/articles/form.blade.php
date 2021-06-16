@extends('layouts.index')

@section('title', 'Новая статья')

@section('content')
<div class="row">

    <div class="col-md-8">
        <h3 class="pb-3 mb-4 font-italic border-bottom">Новая статья</h3>
        <form action="/articles/ajax/save" method="post" data-redirect="/">
            @csrf
            <div class="row">
                <div class="col-6 form-group">
                    <label>Название</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="col-6 form-group">
                    <label>Символьный код</label>
                    <input type="text" name="slug" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label>Краткое содержание</label>
                <textarea name="preview" class="form-control" style="resize:none"></textarea>
            </div>
            <div class="form-group">
                <label>Подробное содержание</label>
                <textarea name="description" class="form-control" style="resize:vertical; height: 250px;"></textarea>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="checkoxHasPublic" value="1" name="hasPublic">
                <label class="form-check-label" for="checkoxHasPublic">Сделать публичной</label>
            </div>
            <div class="form-group">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary w-100">Создать</button>
            </div>

        </form>
    </div>

</div><!-- /.row -->
@endsection
