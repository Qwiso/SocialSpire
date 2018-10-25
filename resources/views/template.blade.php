<!doctype html>
<html>

<head>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv="content-type" content="text/html" charset="utf-8">

    <meta property="og:site_name" content="Social Web">
    <meta property="og:url" content="{{request()->url()}}">
    <meta property="og:type" content="website" />
    {{--<meta property="article:author" content="https://www.facebook.com/twitchtracker/" />--}}
    {{--<meta property="article:publisher" content="https://www.facebook.com/twitchtracker/" />--}}
{{--    <meta property="og:image" content="{{$image or "https://scontent-mia1-1.xx.fbcdn.net/hphotos-xlf1/v/t1.0-9/12814463_605063632977200_3650449437422290023_n.png?oh=4b0a2f5262fe27d039f59887d442e8e4&oe=57962B2D"}}"/>--}}
    {{--<meta property="fb:app_id" content="{{env("FACEBOOK_APP_ID")}}" />--}}

    <title>Social Web {{$title or ""}}</title>
    <link rel="shortcut icon" href="{{asset('fav.ico')}}"/>
    <link rel="stylesheet" href="{{asset('dash/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('dash/dist/css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="{{asset('dash/dist/css/skins/skin-black-light.min.css')}}">
    <link rel="stylesheet" href="{{asset('dash/dist/css/brand-colors.min.css')}}">
    {{--<link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">--}}
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    {{--<script>--}}
        {{--(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){--}}
                    {{--(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),--}}
                {{--m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)--}}
        {{--})(window,document,'script','//www.google-analytics.com/analytics.js','ga');--}}
        {{--ga('create', 'UA-51704628-6', 'auto');--}}
        {{--ga('send', 'pageview');--}}
    {{--</script>--}}

    <style>
        .fa-vert {
            vertical-align: middle;
            font-size: 28px;
            text-decoration: none;
        }
        span.badge[contenteditable] {
            display: inline-block;
        }
        span.badge[contenteditable]:empty::before {
            content: attr(data-placeholder);
            display: inline-block;
        }
        span.badge[contenteditable]:empty:focus::before {
            content: attr(data-focused-advice);
        }
    </style>
</head>

<body class="skin-black-light sidebar-collapse sidebar-mini">
<div class="wrapper">
    @include('dash.main-header')

    @if(auth()->guard('web')->check())
    @include('dash.main-sidebar')
    @endif

    <div class="content-wrapper">
        @yield('content-header')
        @yield('content')
        @yield('post-content')
        <div class="clearfix"></div>
    </div>
    {{--@include('dash.main-footer')--}}

    {{--<!-- Control Sidebar -->--}}
    {{--@if(auth()->check())--}}
    {{--@include('dash.control-sidebar')--}}
    {{--<div class="control-sidebar-bg"></div>--}}
    {{--@endif--}}
</div>
</body>
{{--<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.1.0/jquery.contextMenu.min.css">--}}
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.css">
{{--<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">--}}
<script src="{{asset('dash/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
<script src="{{asset('dash/plugins/jQueryUI/jquery-ui.min.js')}}"></script>
<script src="{{asset('dash/bootstrap/js/bootstrap.min.js')}}"></script>
{{--<script src="{{asset('dash/plugins/jscroll/jquery.jscroll.min.js')}}"></script>--}}
{{--<script src="{{asset('dash/plugins/fastclick/fastclick.min.js')}}"></script>--}}
{{--<script src="{{asset('dash/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>--}}
<script src="{{asset('dash/plugins/flot/jquery.flot.min.js')}}"></script>
<script src="{{asset('dash/plugins/flot/jquery.flot.time.js')}}"></script>
<script src="{{asset('dash/dist/js/app.min.js')}}"></script>
@yield('post-script')
</html>