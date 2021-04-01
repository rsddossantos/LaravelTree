<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>LaravelTree - Login</title>
    <link rel="stylesheet" href="{{url('vendor/adminlte/dist/css/adminlte.min.css')}}" />
    <link rel="stylesheet" href="{{url('assets/css/admin.login.css')}}" />
    <script src="{{url('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{url('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
</head>
<body>
    <div class="loginArea">
        <div class="title">
            <img src="{{url('vendor/adminlte/dist/img/tree.jpg')}}" />
            <div><h2><b>Laravel</b>Tree</h2></div>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </div>
        @endif

        <form method="POST">
            @csrf
            <input class="form-control" type="email" name="email" placeholder="Digite seu e-mail" />
            <input class="form-control" type="password" name="password" placeholder="Digite sua senha" />
            <button class="btn btn-dark btn-lg btn-block" type="submit">Entrar</button>

            Ainda não tem cadastro? <a href="{{url('/admin/register')}}">Cadastre-se</a>
        </form>
    </div>
</body>
</html>
