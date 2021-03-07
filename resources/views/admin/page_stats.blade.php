@extends('admin.page')

@section('body')

    <h3>Estatística da Página</h3>

    <table>
        <thead>
        <tr>
            <th>Total de Visualizações</th>
            <th>Data</th>
        </tr>
        </thead>
        <tbody>
        @foreach($views as $view)
            <tr>
                <td>{{$view->total}}</td>
                <td>{{$view->view_date}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
