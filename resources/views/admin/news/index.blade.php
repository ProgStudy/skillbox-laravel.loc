@extends('layouts.index')

@section('title', 'Список новостей')

@section('content')
<div class="row">
    <div class="col-md-12 blog-main">
        <h3 class="pb-3 mb-4 font-italic border-bottom">@yield('title')</h3>
            {{ $news->links() }}
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Символьный код</th>
                        <th>Название</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($news) < 1)
                        <tr>
                            <td colspan="5">
                                <h3 class="h3 text-center text-warning">Пустой список</h3>
                            </td>
                        </tr>
                    @else
                    @foreach ($news as $itemNews)
                    <tr>
                        <td>{{$itemNews->id}}</td>
                        <td><a href="/news/{{$itemNews->slug}}" target="_blank" class="link">{{$itemNews->slug}}</a></td>
                        <td>{{$itemNews->name}}</td>
                        <td>
                            <div class="text-center">
                                <a href="news/{{$itemNews->id}}/edit" class="btn btn-outline-primary far fa-edit"></a>
                                <form class="d-inline" action="news/{{$itemNews->id}}" data-redirect="/admin/news" method="delete" data-confirm-message="Вы точно хотите удалить статью?">
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
                            <a href="news/create" class="btn btn-outline-success w-100 fas fa-plus-circle"></a>
                        </td>
                    </tr>
                </tfoot>
            </table>
            {{ $news->links() }}
        <br>
    </div><!-- /.blog-main -->
</div><!-- /.row -->
@endsection
