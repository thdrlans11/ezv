@extends('include.layout')

@push('css')
<link type="text/css" rel="stylesheet" href="/devCss/developer.css" />
@endpush

@section('content')
<div class="main-contents">
	<h3 class="main-tit">
        {{ $myEvent->title }}
		<span>행사관리 페이지 입니다.</span>
	</h3>
</div>
@endsection
                