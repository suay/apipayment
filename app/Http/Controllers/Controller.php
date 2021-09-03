<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //open want save log
    // public function systemLog ($user, $subject, $type, $subject_id,$content_log = null) {
    //     $log = new SystemLog;
    //     $log->by_user       = $user;
    //     $log->type          = $type;
    //     $log->subject       = $subject;
    //     $log->subject_id    = $subject_id;
    //     $log->content_log   = $content_log;
    //     $log->save();
    // }
}
