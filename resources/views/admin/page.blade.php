@extends('adminlte::page')

@section('title', 'LaravelTree - '.$page->op_title.' - Links')

@section('content')

    <div class="preheader">
        <h2>Página: {{$page->op_title}}</h2>
    </div>



    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="{{url('/admin/'.$page->slug.'/links')}}">Links</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{url('/admin/'.$page->slug.'/design')}}">Aparência</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{url('/admin/'.$page->slug.'/stats')}}">Estatística</a>
        </li>
    </ul>
    <div class="area">
        <div class="leftside">
            @yield('body')
        </div>
        <div class="rightside">
            <iframe frameborder="0" src="{{url('/'.$page->slug)}}"></iframe>
        </div>
    </div>

@endsection

@section('css')
    <link rel="stylesheet" href="{{url('assets/css/admin.page.css')}}" />
@endsection