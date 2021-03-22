
@extends('admin.page')

@section('body')

    <h3>Editar Aparência</h3>

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" enctype="multipart/form-data">
        @csrf
        <label>
            Mudar foto perfil:<br/>
            <input type="file" name="op_profile_image" />
        </label>
        <label>
            Título:<br/>
            <input type="text" name="op_title" value="{{$page->op_title ?? ''}}" />
        </label>
        <label>
            Descrição:<br/>
            <input type="text" name="op_description" value="{{$page->op_description ?? ''}}" />
        </label>
        <label>
            Slug:<br/>
            <input type="text" name="slug" value="{{$page->slug ?? ''}}" />
        </label>
        <label>
            Cor do fundo 1:<br/>
            <input type="color" name="op_bg_value1" value="{{$page->op_bg_value[0] ?? '#000000'}}" />
        </label>
        <label>
            Cor do fundo 2:<br/>
            <input type="color" name="op_bg_value2" value="{{$page->op_bg_value[1] ?? '#FFFFFF'}}" />
        </label>
        <label>
            Cor da Fonte:<br/>
            <input type="color" name="op_font_color" value="{{$page->op_font_color ?? '#000000'}}" />
        </label>
        <label>
            <input type="submit" value="Salvar" />
        </label>
    </form>

@Stop
