@extends('adminlte::page')

@section('title', 'LaravelTree - Links')

@section('content')

    <h3>{{isset($link) ? 'Editar Link' : 'Novo Link'}}</h3>

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
            <label for="select1">Status</label>
            <select class="form-control" id="select1" name="status">
                <option {{isset($link) ? ($link->status == '1' ? 'selected' : '') : ''}} value="1">Ativado</option>
                <option {{isset($link) ? ($link->status == '0' ? 'selected' : '') : ''}} value="0">Desativado</option>
            </select>
        </div>
        <div class="form-group">
            <label for="title">Título do link</label>
            <input class="form-control" id="title" type="text" name="title" value="{{$link->title ?? ''}}" />
        </div>
        <div class="form-group">
            <label for="url">URL do link:</label>
            <input class="form-control" id="url" type="text" name="href" value="{{$link->href ?? ''}}" />
        </div>
        <div class="form-group">
            <label for="bg">Cor do fundo:</label>
            <input class="form-control" id="bg" type="color" name="op_bg_color" value="{{$link->op_bg_color ?? '#FFFFFF'}}" />
        </div>
        <div class="form-group">
            <label for="tx">Cor do texto:</label>
            <input class="form-control" id="tx" type="color" name="op_text_color" value="{{$link->op_text_color ?? '#000000'}}" />
        </div>
        <div class="form-group">
            <label for="select2">Tipo de borda:</label>
            <select class="form-control" id="select2" name="op_border_type">
                <option {{isset($link) ? ($link->op_border_type == 'square' ? 'selected' : '') : ''}} value="square">Quadrada</option>
                <option {{isset($link) ? ($link->op_border_type == 'rounded' ? 'selected' : '') : ''}} value="rounded">Arredondada</option>
            </select>
        </div>
        <div class="form-group">
            <button class="btn btn-primary btn-block" type="submit">Salvar</button>
        </div>
    </form>

    <script type="text/javascript" src="{{url('assets/js/script_pages.js')}}"></script>
    <script>
        menu[0].firstElementChild.setAttribute('href','{{url('/admin/'.$page->slug.'/links')}}')
        menu[1].firstElementChild.setAttribute('href','{{url('/admin/'.$page->slug.'/design')}}')
        menu[2].firstElementChild.setAttribute('href','{{url('/admin/'.$page->slug.'/stats')}}')
    </script>

        @endsection

@section('css')
    <link rel="stylesheet" href="{{url('assets/css/admin.pages.css')}}" />
@endsection
