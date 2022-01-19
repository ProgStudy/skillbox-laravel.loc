@extends('layouts.index')

@section('title', 'Статистический отчет')

@section('content')
<div class="row">

    <div class="col-md-12 blog-main">
        <h3 class="pb-3 mb-4 font-italic">Статистический отчет</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Описание</th>
                    <th>Результат</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($result as $item)
                    <tr>
                        <td>{{$item['name']}}</td>
                        <td>{!! $item['value'] !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div><!-- /.blog-main -->

</div><!-- /.row -->
@endsection
