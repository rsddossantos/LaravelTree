@extends('adminlte::page')

@section('title', 'LaravelTree - Nova Página')

@section('content')

    <h2>Nova página</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin: 0;">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="form-horizontal" method="POST">
        @csrf
        <div class="form-group">
            <label for="op_title">Título:</label>
            <input class="form-control" id="op_title" type="text" name="op_title" value="{{$page->op_title ?? ''}}" />
        </div>
        <div class="form-group">
            <label for="op_description">Descrição:</label>
            <input class="form-control" id="op_description" type="text" name="op_description" value="{{$page->op_description ?? ''}}" />
        </div>
        <div class="form-group">
            <label for="slug">Slug:</label>
            <input class="form-control" id="slug" type="text" name="slug" value="{{$page->slug ?? ''}}" />
        </div>
        <div class="form-group">
            <button class="btn btn-primary btn-block" type="submit">Salvar</button>
        </div>
    </form>

    <script type="text/javascript" src="{{url('assets/js/script_pages.js')}}"></script>
    <script>
        removeMenu();
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{url('assets/css/admin.pages.css')}}" />
@endsection