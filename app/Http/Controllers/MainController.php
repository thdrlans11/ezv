<?php

namespace App\Http\Controllers;


class MainController extends Controller
{
    public function __construct()
    {        
        view()->share([
            'wrapClass' => 'login',
        ]);
    }

    public function main()
    {   
        if( auth(myAuth())->check() ){
            if( myAuth() == 'admin' ){
                return redirect()->route('event.list');
            }else{
                return redirect()->route('event.intro');
            }
        }

        return view('main');
    }
}
