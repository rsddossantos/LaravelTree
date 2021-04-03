@extends('adminlte::page')

@section('title', 'LaravelTree - Estatística')

@section('content')

    <h3>Estatística da Página</h3>
    <div class="stats">
        <canvas id="rel"></canvas>
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
