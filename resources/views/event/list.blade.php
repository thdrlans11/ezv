@extends('include.layout')

@section('content')
<div class="sch-form-wrap">
    <form action="{{ route('event.list') }}" method="get">
        <fieldset>
            <legend class="hide">검색</legend>
            <div class="sch-wrap">
                <div class="form-group">
                    <input type="text" name="keyword" vlaue="{{ request()->query('keyword') }}" class="form-item sch-key" placeholder="행사명 / 엠투 담당자 / PCO / 사무국 / 행사코드">
                    <button type="submit" class="btn btn-type1 color-type4"><span class="icon"><img src="/assets/image/icon/ic_btn_sch.png" alt=""></span>검색</button>
                    <button type="reset" class="btn btn-type1 btn-line color-type4" onclick="location.href='{{ route('event.list') }}'">
                        <span class="icon"><img src="/assets/image/icon/ic_btn_reset.png" alt=""></span>검색 초기화
                    </button>
                </div>
            </div>
        </fieldset>
    </form>
</div>
<div class="btn-wrap text-right">
    <a href="{{ route('event.form') }}" class="btn btn-type1 color-type10 Load_Base_fix" Wsize="1400" Hsize="900" Tsize="2%" Reload="Y">
        <span class="icon"><img src="/assets/image/icon/ic_btn_add.png" alt=""></span>행사등록
    </a>
</div>
<div class="table-wrap scroll-x">
    <table class="cst-table">
        <caption class="hide">목록</caption>
        <colgroup>
            <col style="width: 7%;">
            <col style="width: 20%;">
            <col>
            <col>
            <col>
            <col>
            <col>
            <col style="width: 10%;">
        </colgroup>
        <thead>
            <tr>
                <th scope="col">번호</th>
                <th scope="col">행사명</th>
                <th scope="col">엠투 담당자</th>
                <th scope="col">PCO</th>
                <th scope="col">학회</th>
                <th scope="col">행사코드</th>
                <th scope="col">행사일</th>
                <th scope="col">관리</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $lists as $event )
            <tr>
                <td>{{ $event->seq }}</td>
                <td>{{ $event->title }}</td>
                <td>{{ $event->m2 }}</td>
                <td>{{ $event->pco ?? '' }}</td>
                <td>{{ $event->client ?? '' }}</td>
                <td>{{ $event->code }}</td>
                <td>{{ $event->date }}</td>
                <td>
                    <a href="{{ route('event.form', ['sid'=>encrypt($event->sid)]) }}" class="btn btn-manage Load_Base_fix" Wsize="1400" Hsize="900" Tsize="2%" Reload="Y">
                        <img src="/assets/image/icon/ic_manage_modify.png" alt="수정">
                    </a>
                    <a href="#n" class="btn btn-manage"><img src="/assets/image/icon/ic_manage_del.png" alt="삭제"></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $lists->links('paginate', ['list'=>$lists]) }}

@endsection
                