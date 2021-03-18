@extends('adminlte::page')


@section('title', 'LaravelTree - Home')

@section('content')

    <header>
        <h2>Suas páginas</h2>
    </header>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Título</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pages as $page)
                <tr>
                    <td>{{$page->op_title}} ({{$page->slug}})</td>
                    <td class="btn-group-vertical">
                        <a class="btn btn-primary" href="{{url('/'.$page->slug)}}" target="_blank">Abrir</a>
                        <a class="btn btn-primary" href="{{url('/admin/'.$page->slug.'/links')}}">Links</a>
                        <a class="btn btn-primary" href="{{url('/admin/'.$page->slug.'/design')}}">Aparência</a>
                        <a class="btn btn-primary" href="{{url('/admin/'.$page->slug.'/stats')}}">Estatística</a>
                        <a class="btn btn-primary" href="{{url('/admin/delPage/'.$page->id)}}" onclick="return confirm('Deseja realmente excluir essa página?')">Excluir</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
