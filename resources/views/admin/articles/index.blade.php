@extends('layouts.index')

@section('title', 'Список статей')

@section('content')
<div class="row">
    <div class="col-md-8 blog-main">
        <h3 class="pb-3 mb-4 font-italic border-bottom">@yield('title')</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Символьный код</th>
                        <th>Название</th>
                        <th>Статус публикации</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($articles) < 1)
                        <tr>
                            <td colspan="5">
                                <h3 class="h3 text-center text-warning">Пустой список</h3>
                            </td>
                        </tr>
                    @else
                    @foreach ($articles as $article)
                    <tr>
                        <td>{{$article->id}}</td>
                        <td><a href="/articles/{{$article->slug}}" target="_blank" class="link">{{$article->slug}}</a></td>
                        <td>{{$article->name}}</td>
                        <td class="text-center">
                            <span class="badge badge-{{$article->has_public ? 'success' : 'danger'}}">{{$article->has_public ? 'Опубликована' : 'Не опубликована'}}</span>
                        </td>
                        <td>
                            <div class="text-center" style="width: 90px;">
                                <a href="articles/{{$article->id}}/edit" class="btn btn-outline-primary far fa-edit"></a>
                                <form class="d-inline" action="articles/{{$article->id}}" method="delete" data-confirm-message="Вы точно хотите удалить статью?">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger far fa-trash-alt"></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-center" colspan="5">
                            <a href="articles/create" class="btn btn-outline-success w-100 fas fa-plus-circle"></a>
                        </td>
                    </tr>
                </tfoot>
            </table>
        <br>
    </div><!-- /.blog-main -->
</div><!-- /.row -->
@endsection