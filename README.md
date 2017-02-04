微信支付的官方文档没有APP支付的Demo，这里根据其网页支付的相关库文件(版本2016.10.11)，制作了一个。主要包含了几个功能：<br/>1、创建预支付订单 wechatCreatePrePay.php<br/>2、微信服务器回调通知处理 wechatNotify.php<br/>3、根据官方的tool，多添加了一个模拟微信服务器回调的工具，用于调试 tool/index.php

#### 其中官方的库文件主要作了如下修改：

- **异步通知url未设置，则使用配置文件中的url**
```
//WxPay.Api.php 46行
if(!$inputObj->IsNotify_urlSet()){
	$inputObj->SetNotify_url(WxPayConfig::NOTIFY_URL);//异步通知url
}
```

- **WxPay.Data.php中添加生成“APP预支付信息的对象”的代码，用于给APP返回已生成的预支付信息的对象**
```
/**
 *
 * @desc APP支付时，返回信息对象
 *
 */
class WxReturnPrepay extends WxPayDataBase {
   /**
    * @desc  设置应用ID
    * @param $value
    */
   public function SetAppid($value) {
      $this->values['appid'] = $value;
   }

   /**
    * @desc  设置商户号
    * @param $value
    */
   public function SetPartnerid($value) {
      $this->values['partnerid'] = $value;
   }

   /**
    * @desc  预支付交易会话ID
    * @param $value
    */
   public function SetPrepayid($value) {
      $this->values['prepayid'] = $value;
   }

   /**
    * @desc  扩展字段(暂填写固定值Sign=WXPay)
    * @param $value
    */
   public function SetPackage($value) {
      $this->values['package'] = $value;
   }

   /**
    * @desc  32位随机字符串
    * @param $value
    */
   public function SetNoncestr($value) {
      $this->values['noncestr'] = $value;
   }

   /**
    * @desc  时间戳
    * @param $value
    */
   public function SetTimestamp($value) {
      $this->values['timestamp'] = $value;
   }
}
```

- **官方代码出现curl错误码60**
```
//WxPay.Api.php 564行：
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验

//作如下修改
if(stripos($url,"https://")!==FALSE){
	curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
 	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
 	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
} else {
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
 	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
}
```

- **WxPay.Api.php支付结果通用通知接口报错**
```
//$xml = $GLOBALS['HTTP_RAW_POST_DATA'];	//414行
$xml = file_get_contents("php://input");
```

- **注释掉官方无用的代码。<br/>WxPay.Notify.php 22行： $this->SetReturn_msg($msg);    这行需要注释掉，不然错误信息会被"OK"覆盖，虽然没什么影响，但还是注释掉比较好**
