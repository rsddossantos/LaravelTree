@extends('adminlte::page')

@section('title', 'LaravelTree - Links')

@section('content')
    <div class="area">
        <div class="leftside">
            <h2>Links</h2>
            <ul id="links">
                <a class="btn btn-primary btn-block" href="{{url('/admin/'.$page->slug.'/newlink')}}">Novo Link</a>
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
                            <a class="btn btn-outline-info"
                               href="{{url('/admin/'.$page->slug.'/editlink/'.$link->id)}}">Editar
                            </a>
                            <a class="btn btn-outline-danger"
                               href="{{url('/admin/'.$page->slug.'/dellink/'.$link->id)}}"
                               onclick="return confirm('Deseja realmente excluir esse link?')">Excluir
                            </a>
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
    <script type="text/javascript" src="{{url('assets/js/script_pages.js')}}"></script>
    <script>
        menu[0].firstElementChild.setAttribute('href','{{url('/admin/'.$page->slug.'/links')}}')
        menu[1].firstElementChild.setAttribute('href','{{url('/admin/'.$page->slug.'/design')}}')
        menu[2].firstElementChild.setAttribute('href','{{url('/admin/'.$page->slug.'/stats')}}')

        new Sortable(document.querySelector('#links'), {
            animation: 150,
            onEnd: async (e) => {
                let id = e.item.getAttribute('data-id');
                // Foi necess?rio diminuir 1 do indice pois o PHP espera index iniciado por zero
                // mas nessa vers?o est? iniciando com 1.
                let link = `{{url('/admin/linkorder/${id}/${e.newIndex-1}')}}`;
                await fetch(link);
                window.location.href = window.location.href;
            }
        });
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{url('assets/css/admin.pages.css')}}" />
@endsection