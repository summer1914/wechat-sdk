<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User;
use GuzzleHttp\Client;
use DB;

class Wechat extends User
{
    const TOKEN = 'nGM5WxHeRWIXsOjCbAjm4lYAZJL/SpuylEzvDK8LPCQ=';
    const PERMANENT = 'QR_LIMIT_SCENE';
    const TEMPOR = 'QR_SCENE';

    public static function makeCode($param = null, $type = self::TEMPOR)
    {
        if ($param === null) {
            return;
        }

        $data = [
        'action_name' => $type,
        'action_info' => ['scene' => ['scene_id' => $param]],
        ];

        if ($type === self::TEMPOR) {
            $data['expire_seconds'] = 604800;
        }

        $request = new Client();
        $res = $request->request('POST', 'https://api.weixin.qq.com/cgi-bin/qrcode/create', [
            'json' => $data,
            'query' =>  ['access_token' => self::TOKEN]
            ])->getBody()->getContent();

        return $res;
    }

    public static function downloadCode($ticket = null)
    {
        if ($ticket === null) {
            return null;
        }

        $client = new Client();
        $url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode';
        $res = $client->request('GET', $url, [
            'query' => ['ticket' => urlencode($ticket)]
            ])->getBody()->getContent();

        return $res;

    }

    public static function valid($nonce = null, $signature = null, $timestamp = null, $response = false)
    {
        if(self::checkSignature($nonce, $signature, $timestamp)){
            $response && self::responseMsg();
            return true;
        } else {
            return false;
        }
    }

    private static function checkSignature($nonce = null, $signature = null, $timestamp = null)
    {
        $tem =  array(self::TOKEN, $timestamp, $nonce);
        sort($tem);
        $temStr = sha1(implode($tem));

        if ($temStr === $signature) {
            return true;
        }

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
