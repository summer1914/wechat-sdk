<?php

namespace App\Models;
use GuzzleHttp\Client;
use DB;
use App\Models\Wechat;
use Illuminate\Support\Facades\Log;

class Planet extends Wechat
{
    const TOKEN = 'nGM5WxHeRWIXsOjCbAjm4Y';
    const PERMANENT = 'QR_LIMIT_SCENE';
    const TEMPOR = 'QR_SCENE';
    const AESKEY = 'hLNoD5nkMzI3HwipVR7wArAM9thz1MbNdDFwtolEwmk';
    const API = 'https://sh.api.weixin.qq.com';
    const APPID = 'wx5734fab052c4d148';
    const SECRET = 'f72346ca61abf08f16b07dae3b2410e9';
    const CODEURL = 'https://mp.weixin.qq.com/cgi-bin/showqrcode';

    function __construct() {
        $init = ['token' => self::TOKEN, 'encodingaeskey' => self::AESKEY, 'appid' => self::APPID, 'appsecret' => self::SECRET];
        parent::__construct($init);
    }
/**
 * [makeCode 创建二维码ticket]
 * @param  [array] $param [param into code]
 * @param  [string] $type  [TEMPOR or PERMANENT]
 * @return [array]        ['ticket' => '', 'url' => '']
 */
    public static function makeCode($param = null, $type = self::TEMPOR)
    {
        $accessToken = DB::table('planet.app_info')->where('appID', self::APPID)->first();
        if($accessToken === null) {
            return ['errcode' => 1, 'errmsg' => 'access_token not found'];
        } else {
            $accessToken = $accessToken->access_token;
        }

        if ($param === null) {
            return;
        }

        $data = [
        'action_name' => $type,
        'action_info' => ['scene' => $param],
        ];

        if ($type === self::TEMPOR) {
            $data['expire_seconds'] = 2592000;
        }

        $request = new Client();
        $res = $request->request('POST', self::API.'/cgi-bin/qrcode/create', [
            'json' => $data,
            'query' =>  ['access_token' => $accessToken]
            ])->getBody()->getContents();

        return json_decode($res, true);
    }

/**
 * [downloadCode 获取二维码]
 * @param  [type] $ticket [ticket]
 * @return [type]         [二维码图片]
 */
    public static function downloadCode($ticket = null)
    {
        if ($ticket === null) {
            return null;
        }

        $client = new Client();

        $res = $client->request('GET', self::CODEURL, [
            'query' => ['ticket' => $ticket]
            ])->getBody()->getContents();

        return $res;

    }

    /*public static function valid($nonce = null, $signature = null, $timestamp = null, $response = false)
    {
        if(self::checkSignature($nonce, $signature, $timestamp)){
            $response && self::responseMsg();
            Log::info('valid successfully: '.$_SERVER["REMOTE_ADDR"].(strstr($_SERVER["REMOTE_ADDR"],'101.226')? " FROM WeiXin": "Unknown IP"));
            return true;
        } else {
            return false;
        }
    }

    private static function checkSignature($nonce = null, $signature = null, $timestamp = null)
    {
        $tem =  array(self::TOKEN, $timestamp, $nonce);
        sort($tem, SORT_STRING);
        $temStr = sha1(implode($tem));

        if ($temStr === $signature) {
            return true;
        }
        Log::info('valid failed: '.$_SERVER["REMOTE_ADDR"].(strstr($_SERVER["REMOTE_ADDR"],'101.226')? " FROM WeiXin": "Unknown IP".'sign:'.$signature.';codeSign:'.$temStr.';nonce:'.$nonce.';timestamp:'.$timestamp));
        return false;
    }*/

    public static function shortUrl($originUrl = null)
    {
        if ($originUrl === null) {
            return null;
        }

        $accessToken = DB::table('planet.app_info')->where('appID', self::APPID)->first();
        if($accessToken === null) {
            return ['errcode' => 1, 'errmsg' => 'access_token not found'];
        } else {
            $accessToken = $accessToken->access_token;
        }

        $client = new Client();
        $res = $client->request('POST', self::API.'/cgi-bin/shorturl',[
            'query' => ['access_token' => $accessToken],
            'json' => ['action' => 'long2short', 'long_url'  => $originUrl]
            ])->getBody()->getContents();

        return json_decode($res, true);
    }

}
