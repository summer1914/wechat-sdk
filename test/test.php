<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Wechat\Wechat;


$options = array(
	'token'=>'tokenaccesskey', //填写你设定的key
	'encodingaeskey'=>'encodingaeskey', //填写加密用的EncodingAESKey
	'appid'=>'wxdk1234567890', //填写高级调用功能的app id
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

//获取菜单操作:
$menu = $testObj->getMenu();
//设置菜单
$newmenu = array(
	"button"=> array(
			array('type'=>'click','name'=>'最新消息','key'=>'MENU_KEY_NEWS'),
			array('type'=>'view','name'=>'我的博客','url'=>'https://www.luojia.ren'),
		)
	);
$result = $testObj->createMenu($newmenu);
