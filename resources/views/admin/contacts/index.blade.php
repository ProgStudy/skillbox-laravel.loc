@extends('layouts.index')

@section('title', 'Список обращений')

@section('content')
<div class="row">

    <div class="col-md-12 blog-main">
        <h3 class="pb-3 mb-4 font-italic border-bottom">Список обращений</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Email</th>
                    <th class="text-center">Сообщение</th>
                    <th class="text-center">Дата получения</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contacts as $contact)
                <tr>
                    <td class="text-center">{{$contact->email}}</td>
                    <td><p>{{$contact->description}}</p></td>
                    <td class="text-center">{{date('d.m.Y', strtotime($contact->created_at))}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div><!-- /.blog-main -->

</div><!-- /.row -->
@endsection