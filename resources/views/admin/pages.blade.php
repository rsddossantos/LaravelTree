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
                <th style="text-align: center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pages as $page)
                <tr>
                    <td width="85%">{{$page->op_title}} ({{$page->slug}})</td>
                    <td align="center">
                        <div align="right" class="btn-group-vertical">
                            <a class="btn btn-dark" href="{{url('/'.$page->slug)}}" target="_blank">Abrir</a>
                            <a class="btn btn-dark" href="{{url('/admin/'.$page->slug.'/links')}}">Links</a>
                            <a class="btn btn-dark" href="{{url('/admin/'.$page->slug.'/design')}}">Aparência</a>
                            <a class="btn btn-dark" href="{{url('/admin/'.$page->slug.'/stats')}}">Estatística</a>
                            <a class="btn btn-dark" href="{{url('/admin/delPage/'.$page->id)}}" onclick="return confirm('Deseja realmente excluir essa página?')">Excluir</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection

@section('css')
    <link rel="stylesheet" href="{{url('assets/css/admin.pages.css')}}" />
@endsection