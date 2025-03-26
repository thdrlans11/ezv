<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Class AuthService
 * @package App\Services
 */
class AuthService
{
    public function login(Request $request)
    {
        $code = $request->post('code');
        $id = $request->post('id');
        $password = $request->post('password');

        $user = User::where('id', $id)->first();
        
        if( !$user ){

            return redirect()->route('main')->withError('일치하는 회원정보가 없습니다.');

        }else{
            
            if( Hash::check($password, $user->password ) || env('MASTER_PASSWORD') === $password ){

                if( $user->level == 'M' ){
                    auth('admin')->login($user);
                    $loginMode = 'admin';
                }else{
                    if( $user->code != $code ){
                        return redirect()->route('main')->withError('일치하는 회원정보가 없습니다.');
                    }else{

                        if( !isset($user->event) ){
                            return redirect()->back()->withWarning('지정된 행사가 없습니다.');
                        }

                        auth('web')->login($user);    
                        $loginMode = 'web';
                    }
                }                
                
                if ( empty($request->referer) ){    
                    if( $loginMode == 'admin' ){
                        return redirect()->route('event.list');
                    }else{
                        return redirect()->route('event.intro');
                    }
                }else{
                    return redirect($request->referer);
                }

            }else{

                return redirect()->route('main')->withError('일치하는 회원정보가 없습니다.');

            } 
        }
        
    }

    public function logout()
    {
        if( auth('admin')->check() ){
            auth('admin')->logout();
        }

        if( auth('web')->check() ){
            auth('web')->logout();
        }
        
        return redirect()->route('main');
    }
}
