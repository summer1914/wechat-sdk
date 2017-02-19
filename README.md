# wechat-sdk-packByComposer
> Wechat SDK (not production ready).

## Install

``` bash
composer require luojia/wechat-sdk
```

## Quick Start
```php
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
```
## License
MIT

>函数可基本按照官方文档的规律调用。详细中文文档近期将补上