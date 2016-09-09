<?php

namespace App\Http\Controllers\Companion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\Wechat;

class GetPeopleController extends Controller
{
    public function entarnce(Request $request)
    {
        $signature = $request->get('signature');
        $timestamp = $request->get('timestamp');
        $nonce = $request->get('nonce');

        $echoStr = $_GET["echostr"];


        if (!Wechat::valid($nonce, $signature, $timestamp)) {
            abort(401);
        } else {
            return response()->json($echoStr);
        }
    }

    public function makeCode()
    {
        $tem = Wechat::makeCode(['orderId' => 'E123456789']);
        return response()->json(['long' => Wechat::CODEURL.'?ticket='.urlencode($tem['ticket']), 'short' => Wechat::shortUrl(Wechat::CODEURL.'?ticket='.urlencode($tem['ticket']))['short_url']]) ;
    }

}
