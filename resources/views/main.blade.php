@extends('include.layout')

@push('scripts')
<script type="text/javascript" src="/devScript/member.js"></script>
@endpush

@section('content')
<div class="wrap login">
    <header id="header" class="inner-layer">
        <h1 class="header-logo"><a href="#n"><img src="/assets/image/common/h1_logo.png" alt="m2community"></a></h1>
    </header>
    <section id="container" class="inner-layer">
        <div class="login-form-wrap">
            <form method="post" action="{{ route('loginProcess') }}" onsubmit="return loginCheck(this)">
                {{ csrf_field() }}

                @if(request()->referer)
                    <input type="hidden" name="referer" value="{{ session()->has('previous_url') ? session()->pull('previous_url') : request()->header('referer') }}">
                @endif

                <fieldset>
                    <legend class="hide">LOGIN</legend>
                    <div class="login-wrap">
                        <div class="login-info">
                            <strong class="login-info-tit font-roboto">
                                <span>EZV</span>
                                SYSTEM
                            </strong>
                            <p class="font-pre">
                                엠투커뮤니티의 시스템을 통해 <br>
                                다양한 세션 정보를 <br>
                                간편하고 빠르게 관리하세요!
                            </p>
                        </div>
                        <div class="form-conbox">
                            <div class="input-box">
                                <div class="form-group">
                                    <img src="/assets/image/icon/ic_login_code.png" alt=""><input type="text" name="code" id="code" class="form-item" placeholder="행사코드">
                                </div>
                                <div class="form-group">
                                    <img src="/assets/image/icon/ic_login_user.png" alt=""><input type="text" name="id" id="id" class="form-item" placeholder="접속계정">
                                </div>
                                <div class="form-group">
                                    <img src="/assets/image/icon/ic_login_pw.png" alt=""><input type="password" name="password" id="password" class="form-item" placeholder="비밀번호">
                                </div>
                            </div>
                            <div class="btn-wrap font-neo">
                                <button type="submit" class="btn btn-type1 btn-login">로그인</button>
                                <a href="#n" class="btn btn-type1 btn-line color-type1"><img src="/assets/image/icon/ic_info.png" alt="">이용가이드</a>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="img-wrap font-roboto">
            <div class="bulb"><strong class="tit">EZV SYSTEM</strong></div>
            <img src="/assets/image/login/img_login.png" alt="">
        </div>
    </section>
</div>
@endsection