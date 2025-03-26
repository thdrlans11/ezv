<?php

namespace App\Services\Event;

use App\Models\Event;
use App\Models\User;
use App\Services\dbService;
use Illuminate\Http\Request;

/**
 * Class EventService
 * @package App\Services
 */
class EventService extends dbService
{
    public function list(Request $request)
    {
        $lists = Event::orderBy('date','desc');
        
        foreach( $request->all() as $key => $val ){
            if( ( $key == 'keyword' ) && $val ){
                $lists->where(function ($q) use ($val) {
                    $q->orWhere('title', 'LIKE', '%'.$val.'%');
                    $q->orWhere('m2', 'LIKE', '%'.$val.'%');
                    $q->orWhere('pco', 'LIKE', '%'.$val.'%');
                    $q->orWhere('client', 'LIKE', '%'.$val.'%');
                    $q->orWhere('code', 'LIKE', '%'.$val.'%');
                });
            }
        }

        $lists = $lists->paginate(20)->appends($request->query());
        $lists = setListSeq($lists);
        $data['lists'] = $lists;

        return view('event.list')->with( $data );
    }

    public function form(Request $request)
    {
        if( $request->sid ){
            $event = Event::find(decrypt($request->sid));
        }

        $data['event'] = $event ?? null;

        return view('event.form')->with( $data );
    }

    public function upsert(Request $request)
    {
        $this->transaction();

        try {    

            if( !$request->sid ){
                $event = new Event();                
            }else{
                $event = Event::find(decrypt($request->sid));
            }
            
            $event->setByPost($request);
            $event->save();

            $this->makeId($request, $event); //계정생성

            $this->dbCommit('행사관리 '.($request->sid ? '수정' : '등록'));

            return redirect()->back()->withSuccess('행사 '.( $request->sid ? '수정' : '등록' ).'이 완료되었습니다.')->with('close','Y');

        } catch (\Exception $e) {

            return $this->dbRollback($e);

        }
    }

    private function makeId($request, $event)
    {
        $m2 = User::where('code', $event->code)->where('level', 'H')->first();
        $pco = User::where('code', $event->code)->where('level', 'P')->first();
        $client = User::where('code', $event->code)->where('level', 'C')->first();
        
        if( $request->m2 ){
            if( $m2 ){
                $m2->id = $event->m2;
                $m2->password = $event->password;
                $m2->access = $event->useMenu;
            }else{
                $m2 = new User();
                $m2->esid = $event->sid;
                $m2->code = $event->code;
                $m2->id = $event->m2;
                $m2->password = $event->password;
                $m2->access = $event->useMenu;
                $m2->level = 'H';
            }
            $m2->save();
        }else{
            if( $m2 ){
                $m2->delete();
            }
        }

        if( $request->pco ){
            if( $pco ){
                $pco->id = $event->pco;
                $pco->password = $event->password;
                $pco->access = $event->pcoAccess;
            }else{
                $pco = new User();
                $pco->esid = $event->sid;
                $pco->code = $event->code;
                $pco->id = $event->pco;
                $pco->password = $event->password;
                $pco->access = $event->pcoAccess;
                $pco->level = 'P';
            }
            $pco->save();
        }else{
            if( $pco ){
                $pco->delete();
            }
        }

        if( $request->client ){
            if( $client ){
                $client->id = $event->client;
                $client->password = $event->password;
                $client->access = $event->clientAccess;
            }else{
                $client = new User();
                $client->esid = $event->sid;
                $client->code = $event->code;
                $client->id = $event->client;
                $client->password = $event->password;
                $client->access = $event->clientAccess;
                $client->level = 'C';
            }
            $client->save();
        }else{
            if( $client ){
                $client->delete();
            }
        }
    }
}
