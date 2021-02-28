@extends('admin.page')

@section('body')

    <h3>{{isset($link) ? 'Editar Link' : 'Novo Link'}}</h3>

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST">
        @csrf
        <label>Status:<br/>
            <select name="status">
                <option {{isset($link) ? ($link->status == '1' ? 'selected' : '') : ''}} value="1">Ativado</option>
                <option {{isset($link) ? ($link->status == '0' ? 'selected' : '') : ''}} value="0">Desativado</option>
            </select>
        </label>
        <label>
            Título do link:<br/>
            <input type="text" name="title" value="{{$link->title ?? ''}}" />
        </label>
        <label>
            URL do link:<br/>
            <input type="text" name="href" value="{{$link->href ?? ''}}" />
        </label>
        <label>
            Cor do fundo:<br/>
            <input type="color" name="op_bg_color" value="{{$link->op_bg_color ?? '#FFFFFF'}}" />
        </label>
        <label>
            Cor do texto:<br/>
            <input type="color" name="op_text_color" value="{{$link->op_text_color ?? '#000000'}}" />
        </label>
        <label>Tipo de borda:<br/>
            <select name="op_border_type">
                <option {{isset($link) ? ($link->op_border_type == 'square' ? 'selected' : '') : ''}} value="square">Quadrada</option>
                <option {{isset($link) ? ($link->op_border_type == 'rounded' ? 'selected' : '') : ''}} value="rounded">Arredondada</option>
            </select>
        </label>
        <label>
            <input type="submit" value="Salvar" />
        </label>
    </form>

@endsection
