@extends('admin.page')

@section('body')

    <h3>Estatística da Página</h3>
    <div class="stats">
        <canvas id="rel"></canvas>
    </div>

    <script type="text/javascript">
        var date = {!! $date !!};
        var qtde = {{$qtde}};
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script type="text/javascript" src="{{url('/assets/js/script_stats.js')}}"></script>

@endsection
