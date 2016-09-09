<?php

namespace App\Http\Controllers\Companion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\Planet;

class GetPeopleController extends Controller
{
    public function entarnce(Request $request)
    {
        $signature = $request->get('signature');
        $timestamp = $request->get('timestamp');
        $nonce = $request->get('nonce');

        $echoStr = $_GET["echostr"];


        if (!Planet::valid($nonce, $signature, $timestamp)) {
            abort(401);
        } else {
            return response()->json($echoStr);
        }
    }

    public function message(Request $request)
    {
        $weObj = new Planet();
        //$weObj->valid();//明文或兼容模式可以在接口验证通过后注释此句，但加密模式一定不能注释，否则会验证失败
        $type = $weObj->getRev()->getRevType();
        switch($type) {
            case Wechat::MSGTYPE_TEXT:
                    $weObj->text("hello, I'm wechat")->reply();
                    exit;
                    break;
            case Wechat::MSGTYPE_EVENT:
                    break;
            case Wechat::MSGTYPE_IMAGE:
                    break;
            default:
                    $weObj->text("help info")->reply();
        }
    }

    public function makeCode()
    {
        $tem = Planet::makeCode(['scene_id' => '123456789']);
        return response()->json(['long' => Planet::CODEURL.'?ticket='.urlencode($tem['ticket']), 'short' => Planet::shortUrl(Planet::CODEURL.'?ticket='.urlencode($tem['ticket']))['short_url']]) ;
    }

}
