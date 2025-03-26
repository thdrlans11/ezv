@extends('include.layoutPopup')

@section('content')
<div class="popup-wrap win-popup-wrap type1">
    <div class="popup-contents">
        <div class="popup-tit-wrap">
            <h3 class="popup-tit">행사 정보 등록</h3>
        </div>
        <div class="popup-conbox">
            <div class="write-form-wrap">
                <form action="{{ route('event.upsert') }}" method="post" onsubmit="return eventCheck(this)" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="sid" id="sid" value="{{ isset($event) && $event->sid ? encrypt($event->sid) : '' }}"/>
                    <fieldset>
                        <legend class="hide">등록</legend>
                        <div class="table-wrap">
                            <table class="cst-table">
                                <caption class="hide">등록</caption>
                                <colgroup>
                                    <col style="width: 20%;">
                                    <col>
                                    <col style="width: 20%;">
                                    <col>
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <th scope="row">행사명</th>
                                        <td class="text-left">
                                            <input type="text" name="title" id="title" value="{{ $event->title ?? '' }}" class="form-item">
                                        </td>
                                        <th scope="row">행사일</th>
                                        <td class="text-left">
                                            <input type="text" name="date" id="date" value="{{ $event->date ?? '' }}" class="form-item datepicker dateCalendar">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">행사코드</th>
                                        <td class="text-left">
                                            @if( isset($event) )
                                            {{ $event->code }}
                                            @else
                                            <input type="text" name="code" id="code" value="{{ $event->code ?? '' }}" class="form-item">
                                            @endif
                                            
                                        </td>
                                        <th scope="row">언어설정</th>
                                        <td class="text-left">
                                            <div class="radio-wrap cst">
                                                @foreach( config('site.event.lang') as $key => $val )
                                                <label for="lang{{ $key }}" class="radio-group">
                                                    <input type="radio" name="lang" id="lang{{ $key }}" value="{{ $key }}" {{ ( $event->lang ?? '' ) == $key ? 'checked' : '' }}>{{ $val }}
                                                </label>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">엠투 계정</th>
                                        <td class="text-left">
                                            <input type="text" name="m2" id="m2" value="{{ $event->m2 ?? '' }}" class="form-item" placeholder="접속 계정으로 사용할 정보 입력">
                                        </td>
                                        <th scope="row">비밀번호</th>
                                        <td class="text-left">
                                            <input type="password" name="password" id="password" class="form-item">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">행사 홈페이지 링크</th>
                                        <td class="text-left" colspan="3">
                                            <input type="text" name="link" id="link" value="{{ $event->link ?? '' }}" class="form-item">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">다른 행사 설정 값 불러오기</th>
                                        <td class="text-left" colspan="3">
                                            <select name="" id="" class="form-item">
                                                <option value="">학회선택</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">사용방법 (APP/WEB)</th>
                                        <td class="text-left">
                                            <div class="radio-wrap cst">
                                                @foreach( config('site.event.useHow') as $key => $val )
                                                <label for="useHow{{ $key }}" class="radio-group">
                                                    <input type="radio" name="useHow" id="useHow{{ $key }}" value="{{ $key }}" {{ ( $event->useHow ?? '' ) == $key ? 'checked' : '' }}>{{ $val }}
                                                </label>
                                                @endforeach

                                                <select name="usePosition" id="usePosition" class="form-item">
                                                    <option value="">선택</option>
                                                    @foreach( config('site.event.usePosition') as $key => $val )
                                                    <option value="{{ $key }}" {{ ( $event->usePosition ?? '' ) == $key ? 'selected' : '' }}>{{ $val }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <th scope="row">기타 연동</th>
                                        <td class="text-left">
                                            <div class="checkbox-wrap cst">
                                                @foreach( config('site.event.peristalsis') as $key => $val )
                                                <label for="peristalsis{{ $key }}" class="checkbox-group">
                                                    <input type="checkbox" name="peristalsis[]" id="peristalsis{{ $key }}" value="{{ $key }}" {{ isset($event->peristalsis) ? ( in_array($key, $event->peristalsis) ? 'checked' : '' ) : '' }}>{{ $val }}
                                                </label>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">인트로 이미지</th>
                                        <td class="text-left">
                                            <div class="filebox">
                                                <input class="upload-name form-item" id="fileName" value="" readonly="readonly">
                                                <label for="userfile">파일 선택</label>
                                                <input type="file" id="userfile" name="userfile" class="file-upload" onclick="return file_check('{{ $event->introFilename ?? '' }}','delfile')" onchange="fileAcceptCheck(this, 'fileName', '');" accept=".jpg, .png, .jpeg, .gif">
                                                @if( isset($event->introRealfile) )
                                                <div class="attach-file">
                                                    <a href="{{ route('download', ['type'=>'only', 'tbl'=>'events', 'sid'=>encrypt($event->sid), 'kind'=>'intro']) }}" target="_blank">{{ $event->introFilename }}</a>
                                                    <input type="checkbox" name="delfile" id="delfile" value="{{ $event->introRealfile ?? '' }}" style="position: relative; top:3px" class="ml-10"/><span class="file-link ml-5">Please check if you wish to delete</span>
                                                </div>
                                                @endif
                                            </div>
                                        </td>
                                        <th scope="row">보팅 이미지</th>
                                        <td class="text-left">
                                            <div class="filebox">
                                                <input class="upload-name form-item" id="fileName2" value="" readonly="readonly">
                                                <label for="userfile2">파일 선택</label>
                                                <input type="file" id="userfile2" name="userfile2" class="file-upload" onclick="return file_check('{{ $event->votingFilename ?? '' }}','delfile2')" onchange="fileAcceptCheck(this, 'fileName2', '');" accept=".jpg, .png, .jpeg, .gif">
                                                @if( isset($event->votingRealfile) )
                                                <div class="attach-file">
                                                    <a href="{{ route('download', ['type'=>'only', 'tbl'=>'events', 'sid'=>encrypt($event->sid), 'kind'=>'voting']) }}" target="_blank">{{ $event->votingFilename }}</a>
                                                    <input type="checkbox" name="delfile2" id="delfile2" value="{{ $event->votingRealfile ?? '' }}" style="position: relative; top:3px" class="ml-10"/><span class="file-link ml-5">Please check if you wish to delete</span>
                                                </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">사용설정 메뉴</th>
                                        <td class="text-left" colspan="3">
                                            <div class="checkbox-wrap cst">
                                                @foreach( config('site.menu.menu') as $key => $val) @if( $key == '1' ) @continue @endif
                                                <label for="useMenu{{ $key }}" class="checkbox-group">
                                                    <input type="checkbox" name="useMenu[]" id="useMenu{{ $key }}" value="{{ $key }}" {{ isset($event->useMenu) ? ( in_array($key, $event->useMenu) ? 'checked' : '' ) : '' }}>{{ $val['name'] }}
                                                </label>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">정보 수집</th>
                                        <td class="text-left" colspan="3">
                                            <div class="checkbox-wrap cst">
                                                @foreach( config('site.event.privacy') as $key => $val )
                                                <label for="privacy{{ $key }}" class="checkbox-group">
                                                    <input type="checkbox" name="privacy[]" id="privacy{{ $key }}" value="{{ $key }}" {{ isset($event->privacy) ? ( in_array($key, $event->privacy) ? 'checked' : '' ) : '' }}>{{ $val }}
                                                </label>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">정보 수집 동의 문구</th>
                                        <td class="text-left" colspan="3">
                                            <textarea name="privacyText" id="privacyText" class="form-item" rows="5">{{ $event->privacyText ?? '' }}</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="col" colspan="4">외부 접속자 정보</th>
                                    </tr>
                                    <tr>
                                        <th scope="row">PCO 담당자</th>
                                        <td class="text-left">
                                            <input type="text" name="pco" id="pco" value="{{ $event->pco ?? '' }}" class="form-item" placeholder="접속 계정명으로 사용할 정보 입력">
                                        </td>
                                        <th scope="row">접근권한</th>
                                        <td class="text-left">
                                            <div class="checkbox-wrap cst">
                                                @foreach( config('site.menu.menu') as $key => $val) @if( $key == '1' ) @continue @endif
                                                <label for="pcoAccess{{ $key }}" class="checkbox-group">
                                                    <input type="checkbox" name="pcoAccess[]" id="pcoAccess{{ $key }}" value="{{ $key }}" {{ isset($event->pcoAccess) ? ( in_array($key, $event->pcoAccess) ? 'checked' : '' ) : '' }}>{{ $val['name'] }}
                                                </label>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">학회 담당자</th>
                                        <td class="text-left">
                                            <input type="text" name="client" id="client" value="{{ $event->client ?? '' }}" class="form-item" placeholder="접속 계정명으로 사용할 정보 입력">
                                        </td>
                                        <th scope="row">접근권한</th>
                                        <td class="text-left">
                                            <div class="checkbox-wrap cst">
                                                @foreach( config('site.menu.menu') as $key => $val) @if( $key == '1' ) @continue @endif
                                                <label for="clientAccess{{ $key }}" class="checkbox-group">
                                                    <input type="checkbox" name="clientAccess[]" id="clientAccess{{ $key }}" value="{{ $key }}" {{ isset($event->clientAccess) ? ( in_array($key, $event->clientAccess) ? 'checked' : '' ) : '' }}>{{ $val['name'] }}
                                                </label>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="col" colspan="4">사용자 QR 페이지용</th>
                                    </tr>
                                    <tr>
                                        <th scope="row">행사장소</th>
                                        <td class="text-left">
                                            <input type="text" name="place" id="place" value="{{ $event->place ?? '' }}" class="form-item">
                                        </td>
                                        <th scope="row">프린트 사용</th>
                                        <td class="text-left">
                                            <div class="checkbox-wrap cst">
                                                <label for="printYn" class="checkbox-group">
                                                    <input type="checkbox" name="printYn" id="printYn" value="Y" {{ ( $event->printYn ?? '' ) == 'Y' ? 'checked' : '' }}>프린트 사용
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">상단 이미지</th>
                                        <td class="text-left">
                                            <div class="filebox">
                                                <input class="upload-name form-item" id="fileName3" value="" readonly="readonly">
                                                <label for="userfile3">파일 선택</label>
                                                <input type="file" id="userfile3" name="userfile3" class="file-upload" onclick="return file_check('{{ $event->topFilename ?? '' }}','delfile3')" onchange="fileAcceptCheck(this, 'fileName3', '');" accept=".jpg, .png, .jpeg, .gif">
                                                @if( isset($event->topRealfile) )
                                                <div class="attach-file">
                                                    <a href="{{ route('download', ['type'=>'only', 'tbl'=>'events', 'sid'=>encrypt($event->sid), 'kind'=>'top']) }}" target="_blank">{{ $event->topFilename }}</a>
                                                    <input type="checkbox" name="delfile3" id="delfile3" value="{{ $event->topRealfile ?? '' }}" style="position: relative; top:3px" class="ml-10"/><span class="file-link ml-5">Please check if you wish to delete</span>
                                                </div>
                                                @endif
                                            </div>
                                        </td>
                                        <th scope="row">하단 이미지</th>
                                        <td class="text-left">
                                            <div class="filebox">
                                                <input class="upload-name form-item" id="fileName4" value="" readonly="readonly">
                                                <label for="userfile4">파일 선택</label>
                                                <input type="file" id="userfile4" name="userfile4" class="file-upload" onclick="return file_check('{{ $event->bottomFilename ?? '' }}','delfile4')" onchange="fileAcceptCheck(this, 'fileName4', '');" accept=".jpg, .png, .jpeg, .gif">
                                                @if( isset($event->bottomRealfile) )
                                                <div class="attach-file">
                                                    <a href="{{ route('download', ['type'=>'only', 'tbl'=>'events', 'sid'=>encrypt($event->sid), 'kind'=>'bottom']) }}" target="_blank">{{ $event->bottomFilename }}</a>
                                                    <input type="checkbox" name="delfile4" id="delfile4" value="{{ $event->bottomRealfile ?? '' }}" style="position: relative; top:3px" class="ml-10"/><span class="file-link ml-5">Please check if you wish to delete</span>
                                                </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">SMS 발신번호</th>
                                        <td class="text-left" colspan="3">
                                            <input type="text" name="smsNumber" id="smsNumber" value="{{ $event->smsNumber ?? '' }}" class="form-item w-50p"> <span class="help-text text-red ml-10">※ 사용자들에게 URL 전달을 위해 발신 번호 등록</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="btn-wrap text-center">
                            <a href="#n" class="btn btn-type1 btn-line color-type3 colorClose">취소</a>
                            <button type="submit" class="btn btn-type1 color-type2"><span class="icon"><img src="/assets/image/icon/ic_btn_chk.png" alt=""></span>저장</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
        <button type="button" class="btn-pop-close colorClose"><span class="hide">닫기</span></button>
    </div>
</div>
@endsection

@push('scripts')
<script>
function eventCheck(f)
{
    if( !$(f.title).val() ){
        swalAlert("행사명을 입력해주세요.", "", "warning", "title");
        return false;
    }
    if( !$(f.date).val() ){
        swalAlert("행사일을 입력해주세요.", "", "warning", "date");
        return false;
    }
    if( !$(f.code).val() && !$(f.sid).val() ){
        swalAlert("행사코드를 입력해주세요.", "", "warning", "code");
        return false;
    }
    if( !$("input:radio[name='lang']").is(":checked") ){
        swalAlert("언어설정을 선택해주세요.", "", "warning", "langK");
        return false;
    }
    if( !$(f.sid).val() ){
        if( !$(f.m2).val() ){
            swalAlert("엠투 계정을 입력해주세요.", "", "warning", "m2");
            return false;
        }
        if( !$(f.password).val() ){
            swalAlert("비밀번호를 입력해주세요.", "", "warning", "password");
            return false;
        }
    }
    if( $("input:checkbox[name='useMenu[]']:checked").length <= 0 ){
        swalAlert("사용설정 메뉴를 하나 이상 선택해주세요.", "", "warning", "useMenu2");
        return false;
    }
    

    return true;
}
</script>
@endpush