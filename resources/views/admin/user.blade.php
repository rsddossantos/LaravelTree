@extends('adminlte::page')

@section('title', 'LaravelTree - Usuário')

@section('content')

    <h2>Dados de acesso</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin: 0;">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('warning'))
        <div class="alert alert-success">{{ session('warning') }}</div>
    @endif

    <form class="form-horizontal" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nome:</label>
            <input class="form-control" id="name" type="text" name="name" value="{{$user->name ?? ''}}" />
        </div>
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input class="form-control" id="email" type="email" name="email" value="{{$user->email ?? ''}}" />
        </div>
        <div class="form-group">
            <label for="password">Senha:</label>
            <input class="form-control" id="password" type="password" name="password" value="{{$user->password ?? ''}}" />
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirmar senha:</label>
            <input class="form-control" id="password_confirmation" type="password" name="password_confirmation" value="{{$user->password ?? ''}}" />
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