<?php

namespace App\Http\Controllers\Companion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Models\Wechat;
use Illuminate\Support\Facades\Log;

class GetPeopleController extends Controller
{
    public function entarnce(Request $request)
    {
        $signature = $request->get('signature');
        $timestamp = $request->get('timestamp');
        $nonce = $request->get('nonce');
        $echostr = $request->get('echoStr');

        if (!Wechat::valid($nonce, $signature, $timestamp)) {
            abort(401);
        } else {
            return response()->json($echoStr);
        }
    }


}
