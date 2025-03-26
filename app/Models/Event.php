<?php

namespace App\Models;

use App\Services\CommonService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'sid';

    protected $guarded = [
        'sid'
    ];

    protected $casts = [
        'peristalsis' => 'object',
        'useMenu' => 'object',
        'privacy' => 'object',
        'pcoAccess' => 'object',
        'clientAccess' => 'object'
    ];

    //비밀번호 암호화
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setByPost($request)
    {
        $this->title = $request->title;
        $this->date = $request->date;
        if( !$request->sid ){
            $this->code = $request->code;
        }
        $this->lang = $request->lang;
        $this->m2 = $request->m2;
        if( $request->password ){
            $this->password = $request->password;
        }
        $this->link = $request->link;
        $this->useHow = $request->useHow;
        $this->usePosition = $request->usePosition;
        $this->peristalsis = $request->peristalsis;
        $this->useMenu = $request->useMenu;
        $this->privacy = $request->privacy;
        $this->privacyText = $request->privacyText;

        $this->pco = $request->pco;
        $this->pcoAccess = $request->pcoAccess;
        $this->client = $request->client;
        $this->clientAccess = $request->clientAccess;
        $this->place = $request->place;
        $this->printYn = $request->printYn ?? 'N';
        $this->smsNumber = $request->smsNumber;

        if( $request->userfile ){
            $file = (new CommonService())->fileUploadService($request->userfile, 'event');
            $this->introFilename = $file['filename'];
            $this->introRealfile = $file['realfile'];            
        }

        if( $request->userfile2 ){
            $file = (new CommonService())->fileUploadService($request->userfile2, 'event');
            $this->votingFilename = $file['filename'];
            $this->votingRealfile = $file['realfile'];            
        }

        if( $request->userfile3 ){
            $file = (new CommonService())->fileUploadService($request->userfile3, 'event');
            $this->topFilename = $file['filename'];
            $this->topRealfile = $file['realfile'];            
        }

        if( $request->userfile4 ){
            $file = (new CommonService())->fileUploadService($request->userfile4, 'event');
            $this->bottomFilename = $file['filename'];
            $this->bottomRealfile = $file['realfile'];            
        }

        if( $request->delfile ){
            (new CommonService())->fileDeleteService($request->delfile);
        }

        if( $request->delfile2 ){
            (new CommonService())->fileDeleteService($request->delfile2);
        }

        if( $request->delfile3 ){
            (new CommonService())->fileDeleteService($request->delfile3);
        }

        if( $request->delfile4 ){
            (new CommonService())->fileDeleteService($request->delfile4);
        }
    }
}
