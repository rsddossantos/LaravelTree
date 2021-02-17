<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{$title}}</title>
    <style type="text/css">
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            padding: 20px;
            font-family: Helvetica, Arial;
            color: {{ $font_color }};
            background: {{ $bg }};
        }
        .profileImage img {
            width: 100px;
            height: 100px;
            border-radius: 50px;
        }
        .profileTitle {
            font-size: 17px;
            font-weight: bold;
            margin-top: 10px;
        }
        .profileDescription {
            font-size: 15px;
            margin-top: 5px;
        }
        .linkArea {
            width: 100%;
            max-width:600px;
            margin: 50px 0;
        }
        .linkArea a {
            display: block;
            padding: 20px;
            text-align: center;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .linkArea a:hover {
            box-shadow:inset 0px 0px 0px 2px #111;
        }
        .linkArea a.linksquare {
            border-radius: 0px;
        }
        .linkArea a.linkrounded {
            border-radius: 50px;
        }
        @foreach ($links as $link)
        .linkArea a:nth-child({{$link->order+1}}) {
            color: {{$link->op_text_color}};
            background-color:{{$link->op_bg_color}}
        }
        @endforeach
        .banner a {
            color: {{ $font_color }};
            text-decoration: none;
        }
        .banner a:hover {
            color: #bb0000;
        }
    </style>
</head>
<body>
    <div class="profileImage">
        <img src="{{ $profile_image }}" />
    </div>
    <div class="profileTitle">{{ $title }}</div>
    <div class="profileDescription">{{ $description }}</div>
    <div class="linkArea">
        @foreach ($links as $link)
            <a href="{{$link->href}}" class="link{{$link->op_border_type}}" target="_blank">
                {{ $link->title }}
            </a>
        @endforeach
    </div>
    <div class="banner">
        <a href="https://b7web.com.br" target="_blank">Feito com ❤ por B7Web</a>
    </div>
    @if(!empty($fb_pixel))
        <!-- Facebook Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t,s)}(window, document,'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ $fb_pixel }}');
            fbq('track', 'PageView');
        </script>
        <noscript>
            <img height="1" width="1" style="display:none"
                 src="https://www.facebook.com/tr?id={{ $fb_pixel }}&ev=PageView&noscript=1"/>
        </noscript>
        <!-- End Facebook Pixel Code -->
    @endif
</body>
</html>
