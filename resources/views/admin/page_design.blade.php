@extends('adminlte::page')

@section('title', 'LaravelTree - Aparência')

@section('content')

    <div class="area">
        <div class="leftside">
            <h2>Editar Aparência</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin: 0;">
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form class="form-horizontal" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Mudar foto perfil:</label>
                    <div class="custom-file">
                        <label class="custom-file-label" for="customFile">Escolher arquivo</label>
                        <input type="file" class="custom-file-input" id="customFile" name="op_profile_image">
                    </div>
                </div>
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
                    <label for="op_bg_value1" >Cor do fundo 1:</label>
                    <input class="form-control" id="op_bg_value1" type="color" name="op_bg_value1" value="{{$page->op_bg_value[0] ?? '#000000'}}" />
                </div>
                <div class="form-group">
                    <label for="op_bg_value2">Cor do fundo 2:</label>
                    <input class="form-control" id="op_bg_value2" type="color" name="op_bg_value2" value="{{$page->op_bg_value[1] ?? '#FFFFFF'}}" />
                </div>
                <div class="form-group">
                    <label for="op_font_color">Cor da Fonte:</label>
                    <input class="form-control" id="op_font_color" type="color" name="op_font_color" value="{{$page->op_font_color ?? '#000000'}}" />
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block" type="submit">Salvar</button>
                </div>
            </form>
        </div>
        <div class="rightside">
            <iframe frameborder="0" src="{{url('/'.$page->slug)}}"></iframe>
        </div>
    </div>

    <script type="text/javascript" src="{{url('vendor/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/script_pages.js')}}"></script>
    <script>
        menu[0].firstElementChild.setAttribute('href','{{url('/admin/'.$page->slug.'/links')}}');
        menu[1].firstElementChild.setAttribute('href','{{url('/admin/'.$page->slug.'/design')}}');
        menu[2].firstElementChild.setAttribute('href','{{url('/admin/'.$page->slug.'/stats')}}');

        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>

@endsection

@section('css')
        <link rel="stylesheet" href="{{url('assets/css/admin.pages.css')}}" />
@endsection