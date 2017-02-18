# wechat-sdk-packByComposer
微信公众号开发SDK包

下载
`composer require luojia/wechat-sdk`

使用
`
<?php
use Wechat\Wechat;


$options = array(
	'token'=>'tokenaccesskey', //key
	'encodingaeskey'=>'encodingaeskey', //EncodingAESKey
	'appid'=>'wxdk1234567890', //app id
	'appsecret'=>'xxxxxxxxxxxxxxxxxxx' //填写高级调用功能的密钥
);

$testObj = new Wechat($options);
$testObj->valid();
$type = $testObj->getRev()->getRevType();
switch($type) {
	case Wechat::MSGTYPE_TEXT:
	$testObj->text("hello, I'm wechat")->reply();
	exit;
	break;
	case Wechat::MSGTYPE_EVENT:
	/** code **/
	break;
	case Wechat::MSGTYPE_IMAGE:
	/** code **/
	break;
	default:
	$testObj->text("help info")->reply();
}
`
更详细的使用文档：(https://github.com/summer1914/wechat-sdk-packByComposer/wiki "Wiki")