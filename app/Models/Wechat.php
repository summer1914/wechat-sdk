<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User;
use GuzzleHttp\Client;
use DB;
use Illuminate\Support\Facades\Log;

class Wechat extends User
{
    const TOKEN = 'nGM5WxHeRWIXsOjCbAjm4Y';
    const PERMANENT = 'QR_LIMIT_SCENE';
    const TEMPOR = 'QR_SCENE';
    const AESKEY = 'hLNoD5nkMzI3HwipVR7wArAM9thz1MbNdDFwtolEwmk';
    const API = 'https://sh.api.weixin.qq.com';
    const APPID = 'wx5734fab052c4d148';
    const SECRET = 'f72346ca61abf08f16b07dae3b2410e9';

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
            return ['error' => 1, 'error_msg' => 'access_token not found'];
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
        $url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode';
        $res = $client->request('GET', $url, [
            'query' => ['ticket' => urlencode($ticket)]
            ])->getBody()->getContents();

        return $res;

    }

    public static function valid($nonce = null, $signature = null, $timestamp = null, $response = false)
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
    }

    public static function responseMsg()
    {
        $postStr = isset($GLOBALS["HTTP_RAW_POST_DATA"]) ? $GLOBALS["HTTP_RAW_POST_DATA"] : null;

        if (!empty($postStr)){
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);
            $time = time();
            $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        <FuncFlag>0</FuncFlag>
                        </xml>";
            if($keyword == "?" || $keyword == "？")
            {
                $msgType = "text";
                $contentStr = "感谢你那么好看还关注稻稻星球，么么！".date("Y-m-d H:i:s",time());
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }
        }else{
            echo "感谢你那么好看还关注稻稻星球，么么！";
            exit;
        }
    }

}
