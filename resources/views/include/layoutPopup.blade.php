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
<title>{{ config('site.common.info.name') }}</title>
<link rel="icon" href="/assets/image/favicon.ico">
<link type="text/css" rel="stylesheet" href="/assets/css/slick.css">
<link type="text/css" rel="stylesheet" href="/assets/css/jquery-ui.min.css">
<!-- <link type="text/css" rel="stylesheet" href="/assets/css/bootstrap.min.css"> -->
<link type="text/css" rel="stylesheet" href="/assets/css/common.css">
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
    @yield('content')

    @include('sweetalert::alert')
</body>
</html>