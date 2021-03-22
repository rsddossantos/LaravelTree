@extends('adminlte::page')

@section('title', 'LaravelTree - Links')

@section('content')
    <div class="area">
        <div class="leftside">
            <h2>Links</h2>
            <a class="bigbutton" href="{{url('/admin/'.$page->slug.'/newlink')}}">Novo Link</a>
            <ul id="links">
                @foreach($links as $link)
                    <li class="link--item" data-id="{{$link->id}}">
                        <div class="link--item--order">
                            <img src="{{url('/assets/images/sort.png')}}" alt="Ordenar" width="18"/>
                        </div>
                        <div class="link--item--info">
                            <div class="link--item--title">{{$link->title}}</div>
                            <div class="link--item--href">{{$link->href}}</div>
                        </div>
                        <div class="link--item--buttons">
                            <a href="{{url('/admin/'.$page->slug.'/editlink/'.$link->id)}}">Editar</a>
                            <a href="{{url('/admin/'.$page->slug.'/dellink/'.$link->id)}}">Excluir</a>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="rightside">
            <iframe frameborder="0" src="{{url('/'.$page->slug)}}"></iframe>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.10.2/Sortable.min.js"></script>
    <script>
        new Sortable(document.querySelector('#links'), {
            animation: 150,
            onEnd: async (e) => {
                let id = e.item.getAttribute('data-id');
                let link = `{{url('/admin/linkorder/${id}/${e.newIndex}')}}`;
                await fetch(link);
                window.location.href = window.location.href;
            }
        });
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{url('assets/css/admin.link.css')}}" />
@endsection