// 로그인 유효성 검사
function loginCheck(f)
{
    if( !$(f.id).val() ){
        swalAlert('아이디를 입력해주세요.', '', 'warning', 'id');
        return false;
    }
    if( $(f.id).val() != "webmaster" ){
        if( !$(f.code).val() ){
            swalAlert('행사코드를 입력해주세요.', '', 'warning', 'code');
            return false;
        }       
    }
    if( !$(f.password).val() ){
        swalAlert('비밀번호를 입력해주세요.', '', 'warning', 'password');
        return false;
    }
    return true;
}