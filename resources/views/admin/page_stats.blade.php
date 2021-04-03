@extends('adminlte::page')

@section('title', 'LaravelTree - Estatística')

@section('content')

    <div class="area">
        <div class="leftside">
            <h2>Estatística da Página</h2>
            <div class="stats">
                <canvas id="rel"></canvas>
            </div>
        </div>
        <div class="rightside">
            <iframe frameborder="0" src="{{url('/'.$page->slug)}}"></iframe>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script type="text/javascript" src="{{url('assets/js/script_pages.js')}}"></script>
    <script type="text/javascript">
        menu[0].firstElementChild.setAttribute('href','{{url('/admin/'.$page->slug.'/links')}}')
        menu[1].firstElementChild.setAttribute('href','{{url('/admin/'.$page->slug.'/design')}}')
        menu[2].firstElementChild.setAttribute('href','{{url('/admin/'.$page->slug.'/stats')}}')

        let date = {!! $date !!};
        let qtde = {{$qtde}};
        let Grafico = document.getElementById('rel').getContext('2d');
        let chart = new Chart(Grafico, {
            type: 'bar',
            data: {
                labels: date,
                datasets: [{
                    label: 'Qtde. de Acessos - Últimos 30 dias',
                    data: qtde,
                    backgroundColor: "#3b5998"
                }]
            }
        });
    </script>

@endsection

@section('css')
    <link rel="stylesheet" href="{{url('assets/css/admin.pages.css')}}" />
@endsection