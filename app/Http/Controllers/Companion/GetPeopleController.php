<?php

namespace App\Http\Controllers\Companion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Models\Wechat;

class GetPeopleController extends Controller
{
    public function entarnce(Request $request)
    {
        $signature = $request->get('signature');
        $timestamp = $request->get('timestamp');
        $nonce = $request->get('nonce');

        $response = $request->has('echostr');

        if (!Wechat::valid($nonce, $signature, $timestamp, $response)) {
            abort(401);
        }
    }

}
