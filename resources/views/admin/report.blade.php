@extends('layouts.index')

@section('title', 'Отчеты')

@section('content')
<input type="hidden" name="userId" value="{{auth()->user()->id}}">
<form action="/admin/reports/ajax/run" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-2">
            <label><b>Посчитать: </b></label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="hasNews" id="checkNews">
                <label class="form-check-label" for="checkNews">
                    Новостей
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="hasArticles" id="checkArticles">
                <label class="form-check-label" for="checkArticles">
                    Статей
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="hasTags" id="checkTags">
                <label class="form-check-label" for="checkTags">
                    Тегов
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="hasComments" id="checkComments">
                <label class="form-check-label" for="checkComments">
                    Комментарий
                </label>
            </div>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">Сгенерировать</button>
        </div>
    </div>
</form>
@endsection