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
            <img id="imgLogo" src="{{url('vendor/adminlte/dist/img/tree.jpg')}}" />
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
            <input class="form-control" type="email" name="email" placeholder="Digite seu e-mail" spellcheck="false" />
            <div class="input-group">
                <input class="form-control pass" type="password" name="password" placeholder="Digite sua senha" spellcheck="false">
                <span class="input-group-btn">
                <button class="btn btn-default eye" id="eye" disabled="disabled">
                    <img id="eyeImg" width="25" height="25" src="{{url('assets/images/close.png')}}" />
                </button>
            </span>
            </div>
            <button class="btn btn-primary btn-lg btn-block" type="submit">Entrar</button>

            Ainda não tem cadastro? <a href="{{url('/admin/register')}}">Cadastre-se</a>
        </form>
    </div>
    <script>

        $('#eyeImg').mouseover(function(){
            $(this).attr("src", "{{url('assets/images/open.png')}}");
            $('.pass').attr('type','text');
        });

        $('#eyeImg').mouseout(function(){
            $(this).attr("src", "{{url('assets/images/close.png')}}");
            $('.pass').attr('type','password');
        });

    </script>
</body>
</html>
