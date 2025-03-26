<!doctype html>
<html lang="ko" class="root-text-sm">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10,user-scalable=yes,viewport-fit=cover">
<meta name="format-detection" content="telephone=no, address=no, email=no">
<meta name="Author" content="{{ config('site.common.info.name') }}">
<meta name="Keywords" content="{{ config('site.common.info.name') }}">
<meta name="description" content="{{ config('site.common.info.name') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="icon" href="/assets/image/favicon.ico">
<link type="text/css" rel="stylesheet" href="/assets/css/slick.css">

<link type="text/css" rel="stylesheet" href="/assets/css/common.css">
<link type="text/css" rel="stylesheet" href="/devCss/jquery_ui.css" />
<link type="text/css" rel="stylesheet" href="/devScript/colorbox/example3/colorbox.css" />
@stack('css')

<script type="text/javascript" src="/assets/js/jquery-3.7.1.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/js/slick.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.rwdImageMaps.js"></script>
<script type="text/javascript" src="/assets/js/common.js"></script>
<script type="text/javascript" src="/devScript/common.js"></script>
<script src="/devScript/colorbox/jquery.colorbox-min.js"></script>
@stack('scripts')
</head>
<body>
    @if( !isset($wrapClass) )
    <div class="wrap">
        <header id="header" class="js-header">
            <div class="header-wrap">
                <h1 class="header-logo">
                    <a href="#n">
                        <span class="logo"><img src="/assets/image/common/h1_logo.png" alt="M2community"></span>
                        EZV SYSTEM
                    </a>
                </h1>
                <button type="button" class="btn btn-menu-open">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
            <nav id="gnb">
                <ul class="gnb js-gnb">
                    @foreach( config('site.menu.menu') as $key => $val ) @if( ( myAuth() == 'admin' && $key > '1' ) || ( myAuth() == 'web' && $key == '1' ) ) @continue @endif
                    <li>
                        <a href="{{ route($val['route_target'],$val['route_param']) }}">{{ $val['name'] }}</a>
                        @if( isset( config('site.menu.sub_menu')[$key] ) )
                        <ul>
                            @foreach( config('site.menu.sub_menu')[$key] as $skey => $sval )
                            <li><a href="{{ route($sval['route_target'],$sval['route_param']) }}">{{ $sval['name'] }}</a></li>
                            @endforeach
                        </ul>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </nav>
        </header>
        <section id="container">
            <div class="contop">
                <h2>{{ $myEvent->title ?? '' }}</h2>
                <ul class="util-menu">
                    <li class="guide">
                        <a href="#n" target="_blank" class="btn"><img src="/assets/image/common/ic_util_info.png" alt="">이용가이드</a>
                    </li>
                    @if( isset($myEvent) && $myEvent->link )
                    <li class="home">
                        <a href="{{ $myEvent->link }}" target="_blank" class="btn"><img src="/assets/image/common/ic_util_home.png" alt="">행사 Home</a>
                    </li>
                    @endif
                    <li class="logout">
                        <strong>{{ auth(myAuth())->user()->id }}</strong> 님
                        <a href="{{ route('logoutProcess') }}" class="btn btn-logout"><span class="hide">로그아웃</span></a>
                    </li>
                </ul>
            </div>
            <div class="contents">
                @isset($mainNum)
                <div class="sub-tit-wrap">
                    <h3 class="sub-tit">{{ config('site.menu.menu')[$mainNum]['name'] }}</h3>
                </div>
                @endisset
                <div class="sub-conbox">
    @endif
                     @yield('content')         

    @if( !isset($wrapClass) )        
                </div>
            </div>
        </section>
    </div>
    @endif

    @include('sweetalert::alert')
</body>
</html>
